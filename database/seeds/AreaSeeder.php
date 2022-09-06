<?php

use Illuminate\Database\Seeder;
use App\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create(['name'=>'北海道']);
        Area::create(['name'=>'東北']);
        Area::create(['name'=>'関東']);
        Area::create(['name'=>'中部']);
        Area::create(['name'=>'近畿']);
        Area::create(['name'=>'中国・四国']);
        Area::create(['name'=>'九州']);
        Area::create(['name'=>'九州・沖縄']);
    }
}
