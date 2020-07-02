<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Location;

class Sponsor extends Model
{
  protected $table = "sponsors";

  public function locations(){
    return $this -> hasMany(Location::class);
  }
}
