<?php

namespace App\Helper;

use Illuminate\Support\Carbon;

class Helper
{
    public static function isJson($args) {
        $result = json_decode($args);
        if (is_array($result))
            return true;
        return false;
    }
}
