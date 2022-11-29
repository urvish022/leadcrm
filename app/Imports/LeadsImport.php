<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LeadsImport implements FromCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $filteredData = [];
        foreach($collection as $key => $val){
            if($key != 0 && !is_null($val[1])){
                $row['company'] = $val[0];
                $row['company_website'] = $this->getWebsite($val[1]);
                $row['first_name'] = $val[2];
                $row['last_name'] = $val[3];
                $row['email'] = $val[4];
                $row['linkedin_profile'] = $val[5];
                $row['country'] = $val[6];
                $filteredData[] = $row;
            }
        }

        return $filteredData;
    }

    public function getWebsite($website_url)
    {
        $parsed_url = parse_url($website_url);
        return isset($parsed_url['host']) ? $parsed_url['host'] : $website_url;
    }
}
