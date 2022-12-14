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
        $this->call(AreaSeeder::class);
        $this->call(PrefectureSeeder::class);
        $this->call(RouteSeeder::class);
        $this->call(StationSeeder::class);
    }
}
