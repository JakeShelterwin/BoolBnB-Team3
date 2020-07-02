<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
          HostsSeeder::class,
          SponsorsSeeder::class,
          LocationsSeeder::class,
          LocationMessagesSeeder::class]);
    }
}
