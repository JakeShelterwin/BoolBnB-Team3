<?php

use Illuminate\Database\Seeder;
use App\Sponsor;
class SponsorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Sponsor::class, 3) -> create();
    }
}
