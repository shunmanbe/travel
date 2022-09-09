<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prefecture;
use App\Area;

class PrefectureController extends Controller
{
    public function select(Prefecture $prefecture)
    {
        $input = $request['area'];
        $detail->fill($input)->save();
        return redirect('/itineraries/show');
        
        $area->prefectures()->where('area_id', $area)->get();
        
        
        
        
        
        //$area = Area::find(1);
        //$prefecture = $area->prefectures();
        //dd($prefecture->name);
        
        //return view('itineraries/new_entry_prefecture')->with(['prefectures' => $prefecture->get()]);
    }
}
