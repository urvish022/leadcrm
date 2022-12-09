<?php

namespace App\Traits;

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
}