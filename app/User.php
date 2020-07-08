<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Apartment;
use App\View;

class User extends Authenticatable
{
    use Notifiable;
    // CUSTOMIZZAZIONE
    public function apartments(){
      return $this -> hasMany(Apartment::class);
    }
    public function views(){
      return $this -> hasMany(View::class);
    }
    // FINE CUSCOMIZZAZIONE



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'date_of_birth', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
