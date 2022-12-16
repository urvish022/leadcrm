<?php

namespace App\Repositories;

use App\Models\Leads;
use App\Repositories\BaseRepository;

/**
 * Class LeadsRepository
 * @package App\Repositories
 * @version November 24, 2022, 6:27 pm UTC
*/

class LeadsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Leads::class;
    }

    public function updateOrCreate($checkData, $inserData)
    {
        return Leads::updateOrCreate($checkData,$inserData);
    }

    public function show($id)
    {
        return Leads::with('lead_contacts','lead_categories','created_by')->find($id);
    }

    public function updateData($where,$updateData)
    {
        return Leads::where($where)->update($updateData);
    }

    public function getDashboardCounts($authId)
    {
        $scrapped = Leads::where('status','scrapped')->where('created_by_id',$authId)->count();
        $initital = Leads::where('status','initital')->where('created_by_id',$authId)->count();
        $followup1 = Leads::where('status','followup1')->where('created_by_id',$authId)->count();
        $followup2 = Leads::where('status','followup2')->where('created_by_id',$authId)->count();
        $followup3 = Leads::where('status','followup3')->where('created_by_id',$authId)->count();
        $followup4 = Leads::where('status','followup4')->where('created_by_id',$authId)->count();
        $followup5 = Leads::where('status','followup5')->where('created_by_id',$authId)->count();
        $hold = Leads::where('status','hold')->where('created_by_id',$authId)->count();
        $interested = Leads::where('status','interested')->where('created_by_id',$authId)->count();
        $in = Leads::where('status','in')->where('created_by_id',$authId)->count();
        $out = Leads::where('status','out')->where('created_by_id',$authId)->count();
        $invalid = Leads::where('status','invalid')->where('created_by_id',$authId)->count();

        return compact('scrapped','initital','followup1','followup2','followup3','followup4','followup5','in','hold','interested','out','invalid');
    }

    public function updateMassData($updateData,$ids)
    {
        return Leads::whereIn('id',$ids)->update($updateData);
    }

    public function getWhereInData($ids)
    {
        return Leads::whereIn('id',$ids)->get();
    }

    public function getDetails($id)
    {
        return Leads::with(['lead_contacts'=>function($q){
            $q->where('status',1);
        }])->where(['id'=>$id])->first();
    }
}
