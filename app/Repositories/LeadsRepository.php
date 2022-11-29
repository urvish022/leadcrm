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

    public function getDashboardCounts()
    {
        $scrapped = Leads::where('status','scrapped')->count();
        $leads = Leads::where('status','lead')->count();
        $followup1 = Leads::where('status','followup1')->count();
        $in = Leads::where('status','in')->count();

        return compact('scrapped','leads','followup1','in');
    }
}
