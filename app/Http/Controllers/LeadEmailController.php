<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmailTemplateRequest;
use App\Repositories\LeadsEmailRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class LeadEmailController extends AppBaseController
{
    /** @var  LeadsEmailRepository */
    private $leadsEmailRepository;

    public function __construct(LeadsEmailRepository $leadsEmailRepository)
    {
        $this->leadsEmailRepository = $leadsEmailRepository;
    }

    /**
     * Display a listing of the LeadEmailController.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $leadEmails = $this->leadsEmailRepository->getEmailsTemplatesWithCategory();

        return view('lead_email_templates.index')
            ->with('leadEmails', $leadEmails);
    }

    /**
     * Show the form for creating a new LeadEmailController.
     *
     * @return Response
     */
    public function create(Request $request,$id)
    {
        $options = $this->leadsEmailRepository->getEmailTypesOptions();
        return view('lead_email_templates.create')->with('options',$options);
    }

    /**
     * Store a newly created LeadEmailController in storage.
     *
     * @param CreateLeadEmailControllerRequest $request
     *
     * @return Response
     */
    public function store(CreateEmailTemplateRequest $request)
    {
        $input = $request->all();

        $leadEmailController = $this->leadsEmailRepository->create($input);

        Flash::success('Lead email template saved successfully.');

        return redirect(route('lead-category.show',$request->category_id));
    }

    /**
     * Display the specified LeadEmailController.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $leadEmailController = $this->leadsEmailRepository->find($id);

        if (empty($leadEmailController)) {
            Flash::error('Lead Email Template not found');

            return redirect(route('lead-email-templates.index'));
        }

        return view('lead_email_templates.show')->with('leadEmailController', $leadEmailController);
    }

    /**
     * Show the form for editing the specified LeadEmailController.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $options = $this->leadsEmailRepository->getEmailTypesOptions();

        $leadContacts = $this->leadsEmailRepository->find($id);

        if (empty($leadContacts)) {
            Flash::error('Lead Email Template not found');

            return redirect(route('lead-email-templates.index'));
        }

        return view('lead_email_templates.edit')->with(['options'=>$options,'leadContacts'=> $leadContacts]);
    }

    /**
     * Update the specified LeadEmailController in storage.
     *
     * @param int $id
     * @param UpdateLeadEmailControllerRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $leadEmailController = $this->leadsEmailRepository->find($id);

        if (empty($leadEmailController)) {
            Flash::error('Lead Email Template not found');

            return redirect(route('lead-email-templates.index'));
        }

        $leadEmailController = $this->leadsEmailRepository->update($request->all(), $id);

        Flash::success('Lead Email Template updated successfully.');

        return redirect(route('lead-email-templates.index'));
    }

    /**
     * Remove the specified LeadEmailController from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $leadEmailController = $this->leadsEmailRepository->find($id);

        if (empty($leadEmailController)) {
            Flash::error('Lead Email Template not found');

            return redirect(route('lead-email-templates.index'));
        }

        $this->leadsEmailRepository->delete($id);

        Flash::success('Lead Email Template deleted successfully.');

        return redirect(route('lead-email-templates.index'));
    }

    public function findEmailTemplate(Request $request)
    {
        $input = $request->all();

        $data = $this->leadsEmailRepository->getDefaultEmailTemplate($input);

        return response()->json($data);
    }

    public function activeEmailTemplate($id){
        $leadEmailTemplate = $this->leadsEmailRepository->find($id);
        $category_id = $leadEmailTemplate->category_id;
        $email_type = $leadEmailTemplate->email_type;

        $this->leadsEmailRepository->updateData(compact('category_id','email_type'),['default_status'=>0]);
        $this->leadsEmailRepository->updateData(compact('id'),['default_status'=>1]);
        
        $data = ['status'=>true];
        return response()->json($data);
    }
}
