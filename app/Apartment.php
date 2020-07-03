<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Sponsor;
use App\Service;
use App\Message;

class Apartment extends Model
{
  protected $table = "apartments";

  public function user(){
    return $this -> belongsTo(User::class);
  }
  public function sponsor(){
    return $this -> belongsToMany(Sponsor::class);
  }
  public function services(){
    return $this -> belongsToMany(Service::class);
  }
  public function messages(){
    return $this -> hasMany(Message::class);
  }
}
