<?php

namespace App\Traits;
use Carbon\Carbon;

trait UtilTrait
{
    function australiaPhoneNumberFormat($string) {

        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = preg_replace('/-+/', '', $string);
        $string = str_replace('61','',$string);
        $string = str_replace('1','',$string);

        $string = strlen($string) > 9 ? $string : "0".$string;

        $first_string = substr($string, 0,2);
        $second_string = chunk_split(substr($string,2,10),4, ' ');

        return $first_string." ".$second_string;
    }

    public function convertToUTC($date,$country)
    {
        $db_date = $date;
        if(!is_null($date) && !is_null($country))
        {
            $timezone = $this->gettimezoneByCountry($country);
            date_default_timezone_set($timezone);
            $dateData = Carbon::createFromFormat('d/m/Y H:i',$date);
            $dateData->toAtomString();
            $dateData->setTimezone("UTC");

            $db_date = $dateData->format('Y-m-d H:i:s');
        }

        return $db_date;
    }

    public function gettimezoneByCountry($country){
        if($country == "USA" || $country == "United States"){
            return "America/New_York";
        } else if($country == "UK" || $country == "United Kingdom") {
            return "Europe/London";
        } else if($country == "Australia"){
            return "Australia/Sydney";
        } else if($country == "South Africa"){
            return "Africa/Johannesburg";
        } else if($country == "Canada"){
            return "America/Vancouver";
        } else {
            return "UTC";
        }
    }
}
