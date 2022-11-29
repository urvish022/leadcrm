<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadContactsRequest;
use App\Http\Requests\UpdateLeadContactsRequest;
use App\Repositories\LeadContactsRepository;
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
    private $leadContactsRepository;

    public function __construct(LeadContactsRepository $leadContactsRepo)
    {
        $this->leadContactsRepository = $leadContactsRepo;
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
            ['data' => 'email', 'name' => 'email', 'title' => "Email"],
            ['data' => 'linkedin_profile', 'name' => 'linkedin_profile', 'title' => "Linkedin Profile"],
            ['data' => 'action', 'name' => 'action', 'title' => trans('Action'), 'orderable' => false, 'searchable' => false],
        ];

        $builder_data['ajax'] = [
            'url'=> route('lead-contacts.list'),
            'data' => 'function(d) {
                d.search =  $("#contacts_search").val();
            }',
            'length'=>50,
            'type'=>'POST'
        ];

        $dt_html = $builder->addIndex()
                            ->columns($builder_data['columns'])
                            ->ajax($builder_data['ajax'])
                            ->parameters([
                                'processing' => false,
                                'pageLength'=>100,
                                'searching' => false,
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
        
        $leads->when(request('search'), function ($q){
            return $q->where('first_name', 'LIKE', '%' . request('search') . '%')
            ->orWhere('last_name', 'LIKE', '%' . request('search') . '%')
            ->orWhere('email', 'LIKE', '%' . request('search') . '%')
            ->orWhere('linkedin_profile', 'LIKE', '%' . request('search') . '%');
        });

        $leads->when(empty(request('order')[0]['column']), function($q){
            return $q->orderBy('id','DESC');
        });

        return DataTables::of($leads)
        ->editColumn('company_name', function($leads){
            return "<a href=".route('leads.show',[$leads->lead_id]).">".$leads->leads_detail->company_name."</a>";
        })
        ->editColumn('first_name', function($leads){
            return $leads->first_name." ".$leads->last_name;
        })
        ->editColumn('email', function($leads){
            return "<a href='mailto:'.$leads->email)>".$leads->email."</a>";
        })
        ->editColumn('linkedin_profile', function($leads){
            return "<a href=".$leads->linkedin_profile." target='_blank')>".$leads->linkedin_profile."</a>";
        })
        ->addColumn('action', function($leads) {
            
            $str = "<a href=".route('lead-contacts.show', [$leads->id])." class='btn btn-ghost-success'><i class='fa fa-eye'></i></a>";
            $str .= "<a href=".route('lead-contacts.edit', [$leads->id])." class='btn btn-ghost-info'><i class='fa fa-edit'></i></a>";
            $str .= Form::open(['route' => ['lead-contacts.destroy', $leads->id], 'method' => 'delete'])."".Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"])."".Form::close();
            return $str;
        })
        ->rawColumns(['company_name','email','linkedin_profile','action'])
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
}
