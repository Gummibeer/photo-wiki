<?php

namespace App\Models;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;

class Event extends Model
{
    use AlgoliaEloquentTrait;

    protected $table = 'events';

    protected $fillable = [
        'display_name',
    ];
}
