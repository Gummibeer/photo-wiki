<?php

namespace App\Models;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'display_name',
    ];
}
