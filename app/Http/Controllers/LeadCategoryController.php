<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LeadCategoryRepository;
use App\Http\Requests\CreateLeadCategoryRequest;
use App\Http\Requests\UpdateLeadCategoryRequest;
use Flash;
use Response;

class LeadCategoryController extends AppBaseController
{
    private $leadCategoryRepository;

    public function __construct(LeadCategoryRepository $leadCategoryRepo)
    {
        $this->leadCategoryRepository = $leadCategoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leadCategories = $this->leadCategoryRepository->getCountWithLeads();
        
        return view('lead_categories.index')
            ->with('leadCategories', $leadCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lead_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLeadCategoryRequest $request)
    {
        $input = $request->all();

        $leadCategory = $this->leadCategoryRepository->create($input);

        Flash::success('Lead Category saved successfully.');

        return redirect(route('lead-category.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leadCategory = $this->leadCategoryRepository->find($id);
        
        if (empty($leadCategory)) {
            Flash::error('Category not found');

            return redirect(route('lead-category.index'));
        }

        return view('lead_categories.show')->with('leadCategory', $leadCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leadCategory = $this->leadCategoryRepository->find($id);

        if (empty($leadCategory)) {
            Flash::error('Category not found');

            return redirect(route('lead-category.index'));
        }

        return view('lead_categories.edit')->with('leadCategory', $leadCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLeadCategoryRequest $request, $id)
    {
        $leadCategory = $this->leadCategoryRepository->find($id);

        if (empty($leadCategory)) {
            Flash::error('Lead not found');

            return redirect(route('lead-category.index'));
        }

        $leadCategory = $this->leadCategoryRepository->update($request->all(), $id);

        Flash::success('Lead updated successfully.');

        return redirect(route('lead-category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leadCategory = $this->leadCategoryRepository->find($id);

        if (empty($leadCategory)) {
            Flash::error('Category not found');

            return redirect(route('lead-category.index'));
        }

        $this->leadCategoryRepository->delete($id);

        Flash::success('Category deleted successfully.');

        return redirect(route('lead-category.index'));
    }
}
