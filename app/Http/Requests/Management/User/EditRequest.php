<?php
namespace App\Http\Requests\Management\User;

use App\Http\Requests\Request;
use App\Models\User;

class EditRequest extends Request
{
    public function authorize()
    {
        return \Auth::user()->can('edit', $this->route('user'));
    }
    
    public function rules()
    {
        return [
            'first_name' => [
                'string',
            ],
            'last_name' => [
                'string',
            ],
            'password' => [
                'confirmed',
                'min:'.User::PASSWORD_MIN_LENGTH,
            ],
        ];
    }
}
