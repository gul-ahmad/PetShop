<?php

namespace App\Core;

use App\Models\product;

use Illuminate\Routing\Route;


class HelperFunction {

    /**
     * @return Uuid
     */
    public static function _uuid()
    {
        return md5(date('Y-m-d').microtime().rand());
    }

    
}