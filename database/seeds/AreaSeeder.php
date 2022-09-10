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
        Area::create(['area_name'=>'北海道']);
        Area::create(['area_name'=>'東北']);
        Area::create(['area_name'=>'関東']);
        Area::create(['area_name'=>'中部']);
        Area::create(['area_name'=>'近畿']);
        Area::create(['area_name'=>'中国・四国']);
        Area::create(['area_name'=>'九州・沖縄']);
    }
}
