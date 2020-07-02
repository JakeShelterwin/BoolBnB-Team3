<?php

use Illuminate\Database\Seeder;

use App\Location;
use App\LocationMessage;

class LocationMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(LocationMessage::class, 30) -> make()
                  -> each(function($LocationMessage){
                    $location = Location::inRandomOrder() -> first();
                    $LocationMessage -> location() -> associate($location);
                    $LocationMessage -> save();
                  })
                  ;
    }
}
