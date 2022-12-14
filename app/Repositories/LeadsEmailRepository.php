<?php

namespace App\Repositories;

use App\Models\LeadEmailTemplate;
use App\Repositories\BaseRepository;

/**
 * Class LeadsRepository
 * @package App\Repositories
 * @version November 24, 2022, 6:27 pm UTC
*/

class LeadsEmailRepository extends BaseRepository
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
        return LeadEmailTemplate::class;
    }

    public function updateOrCreate($checkData, $inserData)
    {
        return LeadEmailTemplate::updateOrCreate($checkData,$inserData);
    }
    
    public function show($id)
    {
        return LeadEmailTemplate::with('lead_contacts','lead_categories','created_by')->find($id);
    }

    public function getEmailTypesOptions()
    {
        return LeadEmailTemplate::getEmailTypesOptions();
    }

    public function getDefaultEmailTemplate($data)
    {
        $email_type = $this->getEmailType($data['email_type']);
        
        return LeadEmailTemplate::where('category_id',$data['category_id'])
        ->where('email_type',$email_type)
        ->where('default_status',1)
        ->first();
    }

    public function getEmailType($type)
    {
        if($type == 'scrapped'){
            return 'initial';
        } else if($type == 'initial'){
            return 'followup1';
        } else if($type == 'followup1'){
            return 'followup2';
        } else if($type == 'followup2') {
            return 'followup3';
        } else if($type == 'followup3'){
            return 'followup4';
        } else if($type == 'followup4'){
            return 'followup5';
        } else if($type == 'followup5'){
            return 'thankyou';
        } else if($type == 'out'){
            return 'thankyou';
        }
    }

    public function getEmailsTemplatesWithCategory()
    {
        return LeadEmailTemplate::with('lead_category')->get();
    }

    public function updateData($where,$updateData){
        return LeadEmailTemplate::where($where)->update($updateData);
    }
}
