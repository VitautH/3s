<?php

namespace App;

use Auth;
use App\Model\Employee;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function name()
    {
        if (Auth::user()) {
            $employee = Employee::find(Auth::user()['employee_id']);
            return $employee->first_name . " " . $employee->last_name;
        }
        return '';
    }


}
