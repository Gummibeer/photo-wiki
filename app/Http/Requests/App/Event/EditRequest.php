<?php

namespace App\Http\Requests\App\Event;

use App\Http\Requests\Request;

class EditRequest extends Request
{
    public function authorize()
    {
        return \Auth::user()->can('edit', $this->route('event'));
    }

    public function rules()
    {
        return [
            'display_name' => [
                'required',
                'min:6',
            ],
            'calendar' => [
                'required',
                'in:'.\Datamap::getCalendars()->pluck('name')->implode(','),
            ],
            'starting_at' => [
                'required',
                'date_format:' . trans('helpers.datetimeformat.php'),
            ],
            'ending_at' => [
                'required',
                'date_format:' . trans('helpers.datetimeformat.php'),
                'after:starting_at',
            ],
            'all_day' => [
                'required',
                'boolean',
            ],
        ];
    }
}
