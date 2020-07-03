<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Apartment;

class Service extends Model
{
  protected $table = "services";
  
  public function apartments(){
    return $this -> belongsToMany(Apartment::class);
  }
}
