<?php

namespace App\Exports;

use App\Models\LeadContacts;
use Maatwebsite\Excel\Concerns\FromArray;

class LeadsExport implements FromArray
{
    public function array(): array
    {
        $rows[] = ["Owner","Status","Reach Type","Company","Company Website","First Name","Last Name","Email","Person Linkedin Url",
                    "Title","Email Status","First Phone","Corporate Phone","Employees","Industry","Keywords","Company Email",
                    "Company Linkedin Url","Facebook Url","Twitter Url","City","State","Address","Country","Annual Revenue"];


        $leads = LeadContacts::with(['leads_detail','leads_detail.created_by'])->get();
        
        foreach($leads as $value){
            if(isset($value->leads_detail)){
                $row = [];
                $row[] = $value->leads_detail->created_by->name;
                $row[] = $value->leads_detail->status;
                $row[] = $value->leads_detail->reach_type;
                $row[] = $value->leads_detail->company_name;
                $row[] = $value->leads_detail->company_website;
                $row[] = $value->first_name;
                $row[] = $value->last_name;
                $row[] = $value->email;
                $row[] = $value->linkedin_profile;
                $row[] = $value->title;
                $row[] = $value->email_status;
                $row[] = $value->phone;
                $row[] = $value->leads_detail->company_phone_number;
                $row[] = $value->leads_detail->total_employees;
                $row[] = $value->leads_detail->industry_type;
                $row[] = $value->leads_detail->keywords;
                $row[] = $value->leads_detail->company_email;
                $row[] = $value->leads_detail->linkedin_url;
                $row[] = $value->leads_detail->facebook_url;
                $row[] = $value->leads_detail->twitter_url;
                $row[] = $value->leads_detail->company_city;
                $row[] = $value->leads_detail->company_state;
                $row[] = $value->leads_detail->company_address;
                $row[] = $value->leads_detail->company_origin;
                $row[] = $value->leads_detail->annual_revenue;

                $rows[] = $row;
            }
        }
        
        return $rows;
    }
}
