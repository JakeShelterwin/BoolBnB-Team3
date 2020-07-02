<?php

use Illuminate\Database\Seeder;

use App\Host;

class HostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Host::class, 10) -> create();
    }
}
