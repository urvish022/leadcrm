<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadContactsRequest;
use App\Http\Requests\UpdateLeadContactsRequest;
use App\Repositories\{LeadsRepository,LeadContactsRepository};
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\LeadContacts;
use Datatables;
use HtmlBuilder;
use Flash;
use Form;
use Response;

class LeadContactsController extends AppBaseController
{
    /** @var  LeadContactsRepository */
    private $leadContactsRepository, $leadsRepository;

    public function __construct(LeadContactsRepository $leadContactsRepo, LeadsRepository $leadsRepo)
    {
        $this->leadContactsRepository = $leadContactsRepo;
        $this->leadsRepository = $leadsRepo;
    }

    /**
     * Display a listing of the LeadContacts.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(HtmlBuilder $builder)
    {
        $builder_data['columns'] = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => trans('Sr. No'), 'render' => null, 'orderable' => false, 'searchable' => false],
            ['data' => 'company_name', 'name' => 'company_name', 'title' => "Company Name",'orderable' => false, 'searchable' => false],
            ['data' => 'first_name', 'name' => 'first_name', 'title' => "Name"],
            ['data' => 'details', 'name' => 'details', 'title' => "Details",'orderable' => false, 'searchable' => false],
            ['data' => 'phone', 'name' => 'phone', 'title' => "Phone",'orderable' => false, 'searchable' => false],
            ['data' => 'status', 'name' => 'status', 'title' => "Status"],
            ['data' => 'action', 'name' => 'action', 'title' => trans('Action'), 'orderable' => false, 'searchable' => false],
        ];

        $builder_data['ajax'] = [
            'url'=> route('lead-contacts.list'),
            'length'=>50,
            'type'=>'POST'
        ];

        $dt_html = $builder->addIndex()
                            ->columns($builder_data['columns'])
                            ->ajax($builder_data['ajax'])
                            ->parameters([
                                'processing' => false,
                                'pageLength'=>100,
                                'searching' => true,
                            ]);
        
        return view('lead_contacts.index')
            ->with('dt_html',$dt_html);
    }

    public function list(Request $request)
    {
        $data = $request->all();
        $perpage = !empty($data['length']) ? (int) $data['length'] : 10;
        $filter = isset($data['search']) && is_string($data['search']) ? $data['search'] : '';
        $sort_type = isset($data['order'][0]['dir']) && is_string($data['order'][0]['dir']) ? $data['order'][0]['dir'] : '';
        $sort_col = $data['order'][0]['column'];
        $sort_field = $data['columns'][$sort_col]['data'];
        
        $leads = LeadContacts::whereHas('leads_detail');
        
        $leads->when(request('search')['value'], function ($q){
            return $q->where('first_name', 'LIKE', '%' . request('search')['value'] . '%')
            ->orWhere('last_name', 'LIKE', '%' . request('search')['value'] . '%')
            ->orWhere('email', 'LIKE', '%' . request('search')['value'] . '%')
            ->orWhere('linkedin_profile', 'LIKE', '%' . request('search')['value'] . '%');
        });

        $leads->when(empty(request('order')[0]['column']), function($q){
            return $q->orderBy('id','DESC');
        });

        return DataTables::of($leads)
        ->editColumn('company_name', function($leads){
            if(isset($leads->leads_detail)){
                return "<a href=".route('leads.show',[$leads->lead_id]).">".$leads->leads_detail->company_name."</a>";
            } else {
                return "";
            }
        })
        ->editColumn('first_name', function($leads){
            return $leads->first_name." ".$leads->last_name;
        })
        ->editColumn('phone', function($leads){
            if(!empty($leads->phone) && $leads->phone != 0){
                return "<a href='tel:.$leads->phone.')>".$leads->phone."</a>";
            }
        })
        // ->editColumn('linkedin_profile', function($leads){
        //     return "<a href=".$leads->linkedin_profile." target='_blank')>".$leads->linkedin_profile."</a>";
        // })
        ->editColumn('status', function($leads){
            if($leads->status){
                return "<button type='button' onclick=updateStatus(".$leads->id.",'active') class='btn btn-success'>Active</button>";
            } else {
                return "<button type='button' onclick=updateStatus(".$leads->id.",'inactive') class='btn btn-warning'>Inactive</button>";
            }
        })
        ->addColumn('details',function($leads){
            $str = "";
            $str .= "<a title=".$leads->email." href='mailto:'.$leads->email)><i class='fa fa-envelope'></i></a>";
            $str .= "&nbsp;&nbsp;";
            $str .= "<a href=".$leads->linkedin_profile." target='_blank')><i class='fa fa-linkedin'></i></a>";

            return $str;
        })
        ->addColumn('action', function($leads) {
            
            $str = "<a href=".route('lead-contacts.show', [$leads->id])." class='btn btn-ghost-success'><i class='fa fa-eye'></i></a>";
            $str .= "<a href=".route('lead-contacts.edit', [$leads->id])." class='btn btn-ghost-info'><i class='fa fa-edit'></i></a>";
            $str .= Form::open(['route' => ['lead-contacts.destroy', $leads->id], 'method' => 'delete'])."".Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"])."".Form::close();
            return $str;
        })
        ->rawColumns(['company_name','phone','linkedin_profile','status','action','details'])
        ->addIndexColumn()
        ->escapeColumns()
        ->toJSON();
    }

    /**
     * Show the form for creating a new LeadContacts.
     *
     * @return Response
     */
    public function create()
    {
        return view('lead_contacts.create');
    }

    /**
     * Store a newly created LeadContacts in storage.
     *
     * @param CreateLeadContactsRequest $request
     *
     * @return Response
     */
    public function store(CreateLeadContactsRequest $request)
    {
        $input = $request->all();

        $leadContacts = $this->leadContactsRepository->create($input);

        Flash::success('Lead Contacts saved successfully.');

        return redirect(route('lead-contacts.index'));
    }

    /**
     * Display the specified LeadContacts.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $leadContacts = $this->leadContactsRepository->find($id);

        if (empty($leadContacts)) {
            Flash::error('Lead Contacts not found');

            return redirect(route('lead-contacts.index'));
        }

        return view('lead_contacts.show')->with('leadContacts', $leadContacts);
    }

    /**
     * Show the form for editing the specified LeadContacts.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $leadContacts = $this->leadContactsRepository->find($id);

        if (empty($leadContacts)) {
            Flash::error('Lead Contacts not found');

            return redirect(route('lead-contacts.index'));
        }

        return view('lead_contacts.edit')->with('leadContacts', $leadContacts);
    }

    /**
     * Update the specified LeadContacts in storage.
     *
     * @param int $id
     * @param UpdateLeadContactsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeadContactsRequest $request)
    {
        $leadContacts = $this->leadContactsRepository->find($id);

        if (empty($leadContacts)) {
            Flash::error('Lead Contacts not found');

            return redirect(route('lead-contacts.index'));
        }

        $leadContacts = $this->leadContactsRepository->update($request->all(), $id);

        Flash::success('Lead Contacts updated successfully.');

        return redirect(route('lead-contacts.index'));
    }

    /**
     * Remove the specified LeadContacts from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $leadContacts = $this->leadContactsRepository->find($id);

        if (empty($leadContacts)) {
            Flash::error('Lead Contacts not found');

            return redirect(route('lead-contacts.index'));
        }

        $this->leadContactsRepository->delete($id);

        Flash::success('Lead Contacts deleted successfully.');

        return redirect(route('lead-contacts.index'));
    }

    public function updateStatus($id)
    {
        $leadContacts = $this->leadContactsRepository->find($id);
        $status = $leadContacts->status == 1 ? 0 : 1;

        $this->leadContactsRepository->update(['status'=>$status],$id);
        
        if($status == 0){
            $leadContact = $this->leadContactsRepository->find($id);
            $lead_id = $leadContacts->lead_id;

            $count = $this->leadContactsRepository->getCount(['lead_id'=>$lead_id,'status'=>1]);

            if($count == 0){
                $this->leadsRepository->update(['status'=>'invalid'],$lead_id);
            }
        }

        return response()->json(['status'=>true]);
    }
}
