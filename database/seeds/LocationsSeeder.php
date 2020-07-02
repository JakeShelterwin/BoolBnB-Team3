<?php

use Illuminate\Database\Seeder;
use App\Location;
use App\Sponsor;
use App\Host;
class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Location::class, 20)
                    -> make()
                    -> each(function($location){
                      $host = Host::inRandomOrder() -> first();
                      $sponsor = Sponsor::inRandomOrder() -> first();
                      $location-> host() -> associate($host);
                      $location-> sponsor() -> associate($sponsor);
                      $location -> save();
                    });
    }
}
