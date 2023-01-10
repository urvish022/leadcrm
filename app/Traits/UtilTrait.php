<?php

namespace App\Traits;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\Cache;

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

            $db_date = $dateData->format('d/m/Y H:i');
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
        } else if($country == "India"){
            return "Asia/Kolkata";
        } else {
            return "UTC";
        }
    }

    public function setMailConfig($userId)
    {
        $configStatus = false;
        try{
            if (Cache::has('users_settings')) {

                $user_settings = Cache::get('users_settings');
                $index = array_search($userId, array_column($user_settings, 'user_id'));
                $user_setting = $user_settings[$index];

                if(isset($user_setting) && !empty($user_setting)){

                    $smtpMailConfig = [
                        'transport'=>$user_setting['mail_type'],
                        'host'=>$user_setting['mail_host'],
                        'port'=>$user_setting['mail_port'],
                        'encryption'=>$user_setting['mail_encryption'],
                        'username'=>$user_setting['mail_username'],
                        'password'=>$user_setting['mail_password']
                    ];

                    Config::set(['mail.mailers.smtp' => $smtpMailConfig]);

                    $fromConfig = [
                        'address' => $user_setting['mail_from_address'],
                        'name' => $user_setting['mail_from_name']
                    ];

                    Config::set(['mail.from'=>$fromConfig]);

                    $configStatus = true;
                }

            }
        } catch(\Exception $e){

        }
        return $configStatus;
    }
}
