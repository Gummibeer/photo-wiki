<?php

namespace App\Models;

use Fenos\Notifynder\Traits\Notifable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'nickname',
        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'display_name',
    ];

    public function avatar($size = 32)
    {
        return 'https://gravatar.com/avatar/' . md5($this->email) . '?d=mm&s=' . $size;
    }

    public function getDisplayNameAttribute()
    {
        if (empty($this->first_name) && empty($this->last_name)) {
            return $this->nickname;
        }
        return (empty($this->first_name)) ? $this->last_name : $this->first_name . ' ' . $this->last_name;
    }

    public function scopeEmail(Builder $query, $email)
    {
        $query->where('email', $email);
    }
}
