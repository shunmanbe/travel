<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Place;
use Carbon\Carbon;

class DetailController extends Controller
{
    public function date_select()
    {
        return view('itineraries/new_entry_date');
    }
    
     public function show(Detail $itinerary)
    {
        return view('itineraries/show')->with(['detail' => $itinerary]);
    }
    
    public function date_store(Request $request, Detail $detail)//日付を保存
    {
        //$input_dd = $request['departure_date'];
        //$detail->fill($input_dd)->save();
        //$input_ed = $request['end_date'];
        //$detail->fill($input_ed)->save();
        $input = $request['date'];
        $detail->fill($input)->save();
        return redirect('/itineraries/new_entry_area');//地域選択画面へ
    }
    
    public function area_store(Request $request, Detail $detail)//出発地域を保存
    {
        $input_a = $request['area_name'];
        $detail->fill($input_a)->save();
        return redirect('/itineraries/new_entry_prefecture');//都道府県選択画面へ
    }
    
    public function prefecture_store(Request $request, Detail $detail)//出発都道府県を保存
    {
        $input_p = $request['prefecture_name'];
        $detail->fill($input_p)->save();
        return redirect('itineraries/new_entry_station');//出発駅選択画面へ
    }
    
    
    
    
    
     public function new_entry_date()
    {
        return view('itineraries/new_entry_date');
    }




}
