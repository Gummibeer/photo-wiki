<?php

namespace App\Http\Requests\App\Event;

use App\Http\Requests\Request;
use Carbon\Carbon;

class CreateRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
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
                'date_format:'.trans('helpers.datetimeformat.php'),
                'after:'.Carbon::now()->startOfDay(),
            ],
            'ending_at' => [
                'required',
                'date_format:'.trans('helpers.datetimeformat.php'),
                'after:starting_at',
            ],
            'all_day' => [
                'required',
                'boolean',
            ],
        ];
        if (\Auth::guest()) {
            $rules['g-recaptcha-response'] = [
                'required',
                'captcha',
            ];
        }

        return $rules;
    }
}
