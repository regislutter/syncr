<?php

namespace App\Helpers;

class ActiveRoute {
    public static function is_active($route){
        return (\Request::is($route.'/*') || \Request::is($route)) ? "active" : '';
    }
}