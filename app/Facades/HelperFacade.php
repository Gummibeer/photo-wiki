<?php

namespace App\Facades;

use App\Libs\Helper;
use Illuminate\Support\Facades\Facade as IlluminateFacade;

class HelperFacade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
