<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


    /**
    * @SWG\Definition(
    *          definition="User",
    *          required={"name", "email" , "password"},
    *          @SWG\Property(property="email", type="string"),
    *          @SWG\Property(property="password", type="string"),
    *          @SWG\Property(property="name", type="string"),
    *      )
    */

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
