<?php

namespace App\Repositories;

use App\Models\LeadContacts;
use App\Repositories\BaseRepository;

/**
 * Class LeadContactsRepository
 * @package App\Repositories
 * @version November 25, 2022, 12:44 am UTC
*/

class LeadContactsRepository extends BaseRepository
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
    public function model(){
        return LeadContacts::class;
    }

    public function updateOrCreate($checkData, $insertData){
        return LeadContacts::updateOrCreate($checkData,$insertData);
    }

    public function getCount($where){
        return LeadContacts::where($where)->count();
    }

    public function getWhereData($where)
    {
        return LeadContacts::where($where)->get();
    }
}
