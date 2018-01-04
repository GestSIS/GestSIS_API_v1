<?php
namespace App\Core;

class DateHelper {

    public static function toIso8601($date){
        return is_null($date) ? null : date('c', strtotime($date));
    }
}
