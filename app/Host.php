<?php

namespace App;

use App\Location;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
  protected $table = "hosts";

  public function locations(){
    return $this -> hasMany(Location::class);
  }

}
