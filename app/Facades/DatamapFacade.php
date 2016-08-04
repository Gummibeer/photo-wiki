<?php

namespace App\Facades;

use App\Libs\Datamap;
use Illuminate\Support\Facades\Facade as IlluminateFacade;

class DatamapFacade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return Datamap::class;
    }
}
