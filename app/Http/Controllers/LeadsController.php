<?php

namespace App\Http\Controllers;

use App\Http\Requests\{CreateLeadsRequest,UpdateLeadsRequest,CreateImportLeadRequest};
use App\Repositories\{LeadCategoryRepository,LeadsRepository,LeadContactsRepository,LeadsActivitiesRepository,LeadsEmailRepository,EmailHistoryRepository,EmailScheduleRepository};
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Imports\LeadsImport;
use App\Models\Leads;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Traits\UtilTrait;
use App\Exports\LeadsExport;
use Carbon\Carbon;
use QuickEmailVerification;
use Session;
use Config;
use Flash;
use Response;
use Excel;
use DB;
use Datatables;
use HtmlBuilder;
use Form;

class LeadsController extends AppBaseController
{
    use UtilTrait;
    /** @var  LeadsRepository */
    private $leadsRepository, $leadCategoryRepository, $leadContactsRepository, $leadActivitiesRepository, $leadsEmailRepository, $emailHistoryRepository;

    public function __construct(LeadsRepository $leadsRepo,
    LeadCategoryRepository $leadCategoryRepo,
    LeadsActivitiesRepository $leadActivitiesRepository,
    LeadContactsRepository $leadContactsRepository,
    EmailHistoryRepository $emailHistoryRepository,
    EmailScheduleRepository $emailScheduleRepository,
    LeadsEmailRepository $leadsEmailRepository)
    {
        $this->leadsRepository = $leadsRepo;
        $this->leadCategoryRepository = $leadCategoryRepo;
        $this->leadContactsRepository = $leadContactsRepository;
        $this->leadActivitiesRepository = $leadActivitiesRepository;
        $this->leadsEmailRepository = $leadsEmailRepository;
        $this->emailHistoryRepository = $emailHistoryRepository;
        $this->emailScheduleRepository = $emailScheduleRepository;
    }

    public function import_store(CreateImportLeadRequest $request)
    {
        try{
            DB::beginTransaction();
            $filteredData = [];
            $leads_data = Excel::toCollection(collect(),$request->leads_file)->toArray();

            foreach($leads_data[0] as $key => $val){
                if($key != 0 && !is_null($val[1])){
                    $company_name = ucwords($val[0]);
                    $company_website = $this->getWebsite($val[1]);
                    $first_name = ucfirst($val[2]);
                    $last_name = ucfirst($val[3]);
                    $email = strtolower($val[4]);
                    $linkedin_profile = $val[5];
                    $title = $val[6];
                    $email_status = $val[7];
                    $employee_phone_number = $this->australiaPhoneNumberFormat($val[8]);
                    $company_phone_number = $this->australiaPhoneNumberFormat($val[9]);
                    $employees = $val[10];
                    $industry = $val[11];
                    $keywords = $val[12];
                    $company_email = strtolower($val[13]);
                    $company_linkedin_url = $val[14];
                    $company_facebook_url = $val[15];
                    $company_twitter_url = $val[16];
                    $city = $val[17];
                    $state = $val[18];
                    $company_address = $val[19];
                    $country = $val[20];
                    $revenue = $val[21];

                    $leadData = $this->leadsRepository->updateOrCreate(['company_website'=>$company_website],[
                        'created_by_id'=> auth()->id(),
                        'category_id'=> $request->category_id,
                        'company_name'=>$company_name,
                        'company_email'=>preg_replace('/[\x00-\x1F\x80-\xFF]/', '',$company_email),
                        'company_phone_number'=>$company_phone_number,
                        'company_website'=>$company_website,
                        'total_employees'=>$employees,
                        'facebook_url'=>$company_facebook_url,
                        'linkedin_url'=>$company_linkedin_url,
                        'twitter_url'=>$company_twitter_url,
                        'industry_type'=>$industry,
                        'company_origin'=>$country,
                        'company_state'=>$state,
                        'company_city'=>$city,
                        'company_address'=>$company_address,
                        'annual_revenue'=>$revenue,
                        'keywords'=>$keywords,
                        'status'=>'scrapped'
                    ]);

                    if($leadData)
                    {
                        $this->leadContactsRepository->updateOrCreate(['email'=>$email],[
                            'lead_id'=>$leadData->id,
                            'first_name'=>$first_name,
                            'last_name'=>$last_name,
                            'title'=>$title,
                            'email'=>preg_replace('/[\x00-\x1F\x80-\xFF]/', '',$email),
                            'email_status'=>$email_status,
                            'phone'=>$employee_phone_number,
                            'linkedin_profile'=>$linkedin_profile
                        ]);
                    }
                }
            }
            DB::commit();
            Flash::success('Prospect imported successfully!');
            return redirect(route('leads.index'));
        } catch(\exception $e){
            \Log::error($e);
            DB::rollback();
            Flash::error('Something went wrong!');
            return redirect(route('leads.index'));
        }

    }

    public function getWebsite($website_url)
    {
        $parsed_url = parse_url($website_url);
        return isset($parsed_url['host']) ? $parsed_url['host'] : $website_url;
    }

    public function import()
    {
        $categories = $this->leadCategoryRepository->all();

        return view('leads.create')
            ->with('categories', $categories);
    }

    public function index(HtmlBuilder $builder)
    {
        $builder_data['columns'] = [
            [
                'title'          => '<input type="checkbox" id="select_all_leads">',
                'data'           => 'checkbox',
                'name'           => 'checkbox',
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => false,
                'width'          => '10px'
            ],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => trans('Sr. No'), 'render' => null, 'orderable' => false, 'searchable' => false],
            ['data' => 'category', 'name' => 'category_name', 'title' => "Niche Category",'orderable' => false, 'searchable' => false],
            ['data' => 'company_name', 'name' => 'company_name', 'title' => "Company"],
            ['data' => 'company_phone_number', 'name' => 'company_phone_number', 'title' => "Phone"],
            ['data' => 'company_details', 'name' => 'company_details', 'title' => "Details",'orderable' => false, 'searchable' => false],
            ['data' => 'company_origin', 'name' => 'company_origin', 'title' => "Country"],
            ['data' => 'total_employees', 'name' => 'total_employees', 'title' => "Employees"],
            ['data' => 'annual_revenue', 'name' => 'annual_revenue', 'title' => "Annual Revenue"],
            ['data' => 'reach_type', 'name' => 'reach_type', 'title' => "Reach"],
            ['data' => 'status', 'name' => 'status', 'title' => "Status"],
            ['data' => 'action', 'name' => 'action', 'title' => trans('Action'), 'orderable' => false, 'searchable' => false],
        ];

        $builder_data['ajax'] = [
            'url'=> route('leads.list'),
            'data' => 'function(d) {
                d.filter = $("#filter_status_select").val();
                d.niche_filter = $("#niche_select").val();
            }',
            'type'=>'POST'
        ];

        $dt_html = $builder->addIndex()
                            ->columns($builder_data['columns'])
                            ->ajax($builder_data['ajax'])
                            ->parameters([
                                'processing' => false,
                                'searching' => true,
                                'pageLength'=>50,
                            ]);

        $leadCategories = $this->leadCategoryRepository->getCountWithLeads();

        $data = compact('dt_html','leadCategories');
        return view('leads.index')
            ->with($data);
    }

    public function list(Request $request)
    {
        try{
            $data = $request->all();
            $perpage = !empty($data['length']) ? (int) $data['length'] : 10;
            $filter = isset($data['search']) && is_string($data['search']) ? $data['search'] : '';
            $sort_type = isset($data['order'][0]['dir']) && is_string($data['order'][0]['dir']) ? $data['order'][0]['dir'] : '';
            $sort_col = $data['order'][0]['column'];
            $sort_field = $data['columns'][$sort_col]['data'];

            $leads = Leads::with(['lead_categories','lead_contacts'])
            ->where('status','!=','invalid')
            ->where('created_by_id',auth()->id());

            $leads = $leads->when(request('search')['value'], function ($q){
                return $q->where('company_name', 'LIKE', '%' . request('search')['value'] . '%')
                    ->orWhere('company_website', 'LIKE', '%' . request('search')['value'] . '%')
                    ->orWhere('company_origin', 'LIKE', '%' . request('search')['value'] . '%');
            });

            $leads = $leads->when(request('filter'), function ($q){
                $q->where('status', '=', request('filter'));
            });

            $leads = $leads->when(request('niche_filter'), function ($q){
                $q->where('category_id', '=', request('niche_filter'));
            });

            $leads = $leads->when(empty(request('order')[0]['column']), function($q){
                return $q->orderBy('id','DESC');
            });

            return DataTables::of($leads)
            ->editColumn('reach_type', function($leads){

                if($leads->reach_type == 'email'){
                    return "<i class='fa fa-envelope'></i> ".ucfirst($leads->reach_type);
                } else if($leads->reach_type == 'call') {
                    return "<i class='fa fa-phone'></i> ".ucfirst($leads->reach_type);
                } else if($leads->reach_type == 'facebook') {
                    return "<i class='fa fa-facebook'></i> ".ucfirst($leads->reach_type);
                } else if($leads->reach_type == 'linkedin') {
                    return "<i class='fa fa-linkedin'></i> ".ucfirst($leads->reach_type);
                } else if($leads->reach_type == 'other') {
                    return "<i class='fa fa-cog'></i> ".ucfirst($leads->reach_type);
                }
            })
            ->editColumn('company_phone_number', function($leads){
                return !empty($leads->company_phone_number) && $leads->company_phone_number != 0 ? $leads->company_phone_number : "";
            })
            ->editColumn('category', function($leads){
                return $leads->lead_categories->category_name;
            })
            ->editColumn('status', function($leads){
                return ucfirst($leads->status);
            })
            ->editColumn('annual_revenue', function($leads){
                if(!empty($leads->annual_revenue)){
                    return "$".number_format($leads->annual_revenue);
                }
            })
            ->addColumn('checkbox', function($leads) {
                return "<input type='checkbox' onclick='checkboxselect()' class='lead-checkboxes' id='lead_checkbox-$leads->id'>";
            })
            ->addColumn('company_details',function($leads){
                $str = "<a href=".'http://'.$leads->company_website." target='_blank'><i class='fa fa-globe'></i></a>";

                if(!empty($leads->company_email)){
                    $str .= "&nbsp;&nbsp;";
                    $str .= "<a href='mailto:$leads->company_email' target='_blank'><i class='fa fa-envelope'></i></a>";
                }

                if(!empty($leads->facebook_url)){
                    $str .= "&nbsp;&nbsp;";
                    $str .= "<a href='$leads->facebook_url' target='_blank'><i class='fa fa-facebook-square'></i></a>";
                }

                if(!empty($leads->linkedin_url)){
                    $str .= "&nbsp;&nbsp;";
                    $str .= "<a href='$leads->linkedin_url' target='_blank'><i class='fa fa-linkedin-square'></i></a>";
                }

                if(!empty($leads->twitter_url)){
                    $str .= "&nbsp;&nbsp;";
                    $str .= "<a href='$leads->twitter_url' target='_blank'><i class='fa fa-twitter-square'></i></a>";
                }

                $str .= "<br>";
                $str .= strlen($leads->keywords) > 100 ? substr($leads->keywords,0,100).", and more.." : $leads->keywords;

                return $str;
            })
            ->addColumn('action', function($leads) {
                $str = "<a data-id=".$leads->id." data-category-id=".$leads->category_id." data-status=".$leads->status." onclick='openMailBoxPopup(this)' class='btn btn-ghost-success'><i class='fa fa-envelope'></i></a>";
                $str .= "<a href=".route('leads.show', [$leads->id])." class='btn btn-ghost-success'><i class='fa fa-eye'></i></a>";
                $str .= "<a href=".route('leads.edit', [$leads->id])." class='btn btn-ghost-info'><i class='fa fa-edit'></i></a>";
                $str .= "<a onclick='changeStatus(".json_encode($leads).")' class='btn btn-ghost-info'><i class='fa fa-tag'></i></a>";
                $str .= Form::open(['route' => ['leads.destroy', $leads->id], 'method' => 'delete'])."".Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"])."".Form::close();
                return $str;
            })
            ->rawColumns(['reach_type','action','checkbox','company_details'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJSON();
        } catch (\Exception $e){
            \Log::error($e);
            return response()->json(['status'=>false,'message'=>'Something went wrong '. $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new Leads.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->leadCategoryRepository->getCountWithLeads();

        return view('leads.create')->with(compact('categories'));
    }

    /**
     * Store a newly created Leads in storage.
     *
     * @param CreateLeadsRequest $request
     *
     * @return Response
     */
    public function store(CreateLeadsRequest $request)
    {
        $input = $request->all();
        $input['created_by_id'] = auth()->id();

        $leads = $this->leadsRepository->create($input);

        Flash::success('Prospect saved successfully.');

        return redirect(route('leads.index'));
    }

    /**
     * Display the specified Leads.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $leads = $this->leadsRepository->show($id);

        if (empty($leads)) {
            Flash::error('Prospect not found');

            return redirect(route('leads.index'));
        }

        return view('leads.show')->with('leads', $leads);
    }

    /**
     * Show the form for editing the specified Leads.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $leads = $this->leadsRepository->find($id);

        if (empty($leads)) {
            Flash::error('Prospect not found');

            return redirect(route('leads.index'));
        }

        return view('leads.edit')->with('leads', $leads);
    }

    /**
     * Update the specified Leads in storage.
     *
     * @param int $id
     * @param UpdateLeadsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeadsRequest $request)
    {
        $leads = $this->leadsRepository->find($id);

        if (empty($leads)) {
            Flash::error('Prospect not found');

            return redirect(route('leads.index'));
        }

        $leads = $this->leadsRepository->update($request->all(), $id);

        Flash::success('Prospect updated successfully.');

        return redirect(route('leads.index'));
    }

    /**
     * Remove the specified Leads from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $leads = $this->leadsRepository->find($id);

        if (empty($leads)) {
            Flash::error('Prospect not found');

            return redirect(route('leads.index'));
        }

        $this->leadsRepository->delete($id);

        Flash::success('Prospect deleted successfully.');

        return redirect(route('leads.index'));
    }

    public function change_status(Request $request)
    {
        try{
            $input = $request->all();
            $status = $this->leadsRepository->updateData(['id'=>$input['selected_lead']],['status'=>$input['selected_status'],'reach_type'=>$input['reach_type_select']]);

            $activityData = ['lead_id'=>$input['selected_lead'],'updated_status'=>$input['selected_status'],'reach_type'=>$input['reach_type_select'],'notes'=>$input['notes']];
            $activityCount = $this->leadActivitiesRepository->getCount($activityData);
            if($activityCount == 0){
                $this->leadActivitiesRepository->create($activityData);
            }

            $data = ['status'=>true,'message'=>'Status updated successfully'];
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>'Something went wrong '. $e->getMessage()]);
        }
    }

    public function bulk_change_status(Request $request)
    {
        try{
            $input = $request->all();
            $status = $this->leadsRepository->updateMassData(['status'=>$input['status']],$input['ids']);

            foreach($input['ids'] as $id){
                $activitiesData = ['lead_id'=>$id,'updated_status'=>$input['status'],'reach_type'=>$input['reach'],'notes'=>$input['note']];
                $this->leadActivitiesRepository->updateOrCreateData($activitiesData);
            }

            $data = ['status'=>true,'message'=>'Status updated successfully'];
            return response()->json($data);
        } catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>'Something went wrong '. $e->getMessage()]);
        }
    }

    public function send_mail(Request $request)
    {
        $user_settings = Session::get('user-settings');

        $email_signature = $user_settings->email_signature;


        $body = $request->body;
        $subject = $request->subject;

        if(env('APP_ENV') == 'local'){
            $to_emails = ['info@techwebsoft.com','urvish31797@gmail.com'];
        } else {
            $to_emails = $request->emails;
            $to_emails = explode(",",$to_emails);
        }

        try{
            $this->setMailConfig(auth()->id());

            $body = View::make('email_template.index')->with(compact('body','email_signature'));

            $status = Mail::html($body,function($message) use($subject,$to_emails,$body,$user_settings){
                $message->to($to_emails)
                ->subject($subject)
                ->replyTo(Config::get('mail.from.address'))
                ->bcc($user_settings->bcc_name)
                ->from(Config::get('mail.from.address'),Config::get('mail.from.name'));
            });

            return response()->json(['status'=>true,'message'=>'Mail sent successfully!']);
        } catch (\Exception $e){
            return response()->json(['status'=>false,'message'=>"Error! something went wrong ".$e->getMessage()]);
        }
    }

    public function save_schedule(Request $request)
    {
        try{
            $inputs = $request->all();
            $leads = $this->leadsRepository->getWhereInData($inputs['companies']);
            $scheduleData = [];
            $user_settings = Session::get('user-settings');
            $interval_days = $user_settings->followup_interval_days;

            foreach($leads as $lead){

                $remaining_stages = $this->getRemainingStages($lead['status']);
                $date = $inputs['date'];
                for($i=0;$i<count($remaining_stages);$i++)
                {
                    if($i != 0){
                        $date = Carbon::createFromFormat('d/m/Y H:i',$date)->addDays($interval_days)->format('d/m/Y H:i');
                    }

                    $date = $this->convertToUTC($date, $lead->company_origin);
                    $emailData = $this->leadsEmailRepository->getEmailTemplate(['email_type'=>$remaining_stages[$i],'category_id'=>$lead['category_id']]);
                    if(!empty($emailData)){
                        $keywords = explode(",",$emailData['keywords']);
                        $body = $emailData['body'];
                        $subject = $emailData['subject'];

                        $emailSubjectBodayData = $this->createEmailSubjectBody($keywords,$subject,$body,$lead);
                        extract($emailSubjectBodayData);

                        if(isset($emails)){
                            $schedule_time = Carbon::createFromFormat('d/m/Y H:i',$date)->format('Y-m-d H:i');
                            $scheduleData[] = [
                                'lead_id'=>$lead->id,
                                'created_by_id'=>auth()->id(),
                                'emails'=>$emails,
                                'schedule_time' => $schedule_time,
                                'subject'=>$subject,
                                'body'=>$body,
                                'status'=>$emailData['email_type']
                            ];
                        }
                    }
                }
            }

            $this->emailScheduleRepository->insert($scheduleData);
            return response()->json(['status'=>true,'message'=>'Mail scheduled successfully!']);
        } catch (\Exception $e){
            return $e;
            return response()->json(['status'=>false,'message'=>"Error! something went wrong ".$e->getMessage()]);
        }
    }

    public function getRemainingStages($current_stage)
    {
        $stages = ['scrapped','initial','followup1','followup2'];
        $index = array_search($current_stage, $stages) + 1;
        $remaining_stages = array_splice($stages,$index);

        return $remaining_stages;
    }

    public function createEmailSubjectBody($keywords,$subject,$body,$lead)
    {
        $emails = null;
        for($i=0;$i<count($keywords);$i++)
        {
            $subject = preg_replace("{".$keywords[$i]."}",$lead->{$keywords[$i]},$subject);

            $subject = str_replace("{","",$subject);
            $subject = str_replace("}","",$subject);

            $body = preg_replace("{".$keywords[$i]."}",$lead->{$keywords[$i]},$body);

            if($keywords[$i] == "company_website"){
                $body = str_replace("http://www.website.com/","http://".$lead->company_website,$body);
            }

            $body = str_replace("{","",$body);
            $body = str_replace("}","",$body);

            $emails = [];

            if(!empty($lead->company_email)){
                $emails[] = $lead->company_email;
            }
            $contacts = $lead->lead_contacts->toArray();
            $contact_emails = array_column($contacts,'email');
            foreach($contact_emails as $email){
                $emails[] = $email;
            }

            $emails = implode(",",$emails);
        }

        return compact('subject','body','emails');
    }

    public function get_lead_details($id, Request $request)
    {
        $input = $request->all();
        $data = $this->leadsRepository->getDetails($id);
        $email_template = $this->leadsEmailRepository->getDefaultEmailTemplate($input);
        $response = ['status'=>true,'data'=>['lead_data'=>$data,'email_template'=>$email_template]];

        return response()->json($response);
    }

    public function export_leads()
    {
        $sheet_name = "leads-export-".now().".xlsx";
        return Excel::download(new LeadsExport(), $sheet_name);
    }

    public function test_email()
    {
        $status = false;
        $email = "chuckm@briteblinds.ca";

        $client   = new QuickEmailVerification\Client(env("QUICKEMAIL_API_KEY"));
        $quickemailverification  = $client->quickemailverification();

        try {
            // SANDBOX MODE
            if(env('APP_ENV') == 'local'){
                $response = $quickemailverification->sandbox($email);
            } else {
                $response = $quickemailverification->verify($email);
            }
        }
        catch (Exception $e) {
            $status = false;
        }

        return $status;
    }

    function isSiteAvailible($url){
        // Check, if a valid url is provided
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            return false;
        }

        // Initialize cURL
        $curlInit = curl_init($url);

        // Set options
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

        // Get response
        $response = curl_exec($curlInit);

        // Close a cURL session
        curl_close($curlInit);

        return $response?true:false;
    }
}
