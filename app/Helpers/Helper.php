<?php

namespace App\Helpers;

use DB;

class Helper
{
    public static function createUrlSlug($urlString){
        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $urlString);
        return strtolower($slug);
    }



     

    public static function generateRandomString($alpha = true, $nums = true, $usetime = false, $string = '', $length = 120) {
        return time().uniqid();
    }

    public static function dateFormat($format, $date){
        return date($format,strtotime($date));
    }
}
