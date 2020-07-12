<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Sponsor;
use App\Service;
use App\Message;
use App\View;

class Apartment extends Model
{
  protected $table = "apartments";

  public function user(){
    return $this -> belongsTo(User::class);
  }
  public function sponsor(){
    return $this -> belongsToMany(Sponsor::class)->withTimestamps();
  }
  public function services(){
    return $this -> belongsToMany(Service::class);
  }
  public function messages(){
    return $this -> hasMany(Message::class);
  }
  public function views(){
    return $this -> hasMany(View::class);
  }
}
