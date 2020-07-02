<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Host;
use App\Sponsor;
use App\LocationMessage;

class Location extends Model
{
  protected $table = "locations";

  public function host(){
    return $this -> belongsTo(Host::class);
  }
  public function sponsor(){
    return $this -> belongsTo(Sponsor::class);
  }
  public function locationMessages(){
    return $this -> hasMany(LocationMessage::class);
  }
}
