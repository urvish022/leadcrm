<?php

namespace App\Repositories;

use App\Models\LeadsActivities;
use App\Repositories\BaseRepository;

/**
 * Class TicketEntriesRepository
 * @package App\Repositories
 * @version February 1, 2022, 10:53 am UTC
*/

class LeadsActivitiesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'updated_status',
        'reach_type',
        'notes'
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
        return LeadsActivities::class;
    }

    public function whereFirst()
    {
        return LeadsActivities::where($where)->first();

    }

    public function getCount($where)
    {
        return LeadsActivities::where($where)->count();
    }

    public function upsertData($insertData,$columnsCheck,$shouldBeUpdated=[]){
        return LeadsActivities::upsert($insertData,$columnsCheck,$shouldBeUpdated);
    }

    public function updateOrCreateData($data)
    {
        return LeadsActivities::updateOrCreate($data);
    }

}
