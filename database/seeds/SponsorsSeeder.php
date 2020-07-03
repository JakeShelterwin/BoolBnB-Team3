<?php

use Illuminate\Database\Seeder;
use App\Sponsor;
use App\Apartment;
class SponsorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Sponsor::class, 3) -> create()
        -> each(function($sponsor){
          $apartments = Apartment::inRandomOrder() -> take(rand(1,10))  -> get();
          $sponsor -> apartments() -> attach($apartments)
        ;
      });
    }
}
