<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Place;
use Carbon\Carbon;
use App\Area;
use App\Prefecture;

class DetailController extends Controller
{
    public function date_select()
    {
        return view('itineraries/new_entry_date');
    }
    
    public function date_store(Request $request, Detail $detail)//日付を保存
    {
        $input_d = $request['date'];
        $detail->fill($input_d)->save();
        return redirect('/itineraries/new_entry/'.$detail->id.'/area');//地域選択画面を表示するweb.phpへ
    }
    
    public function area_select(Area $area, Detail $detail)
    {
        return view('itineraries/new_entry_area')->with(['areas'=>$area->get(), 'detail'=>$detail]);//地域選択画面を表示
    }
    
    
    public function area_store(Request $request, Detail $detail)//出発地域を保存
    {
        $input_a = $request->area;
        $detail->fill($input_a)->save();
        return redirect('/itineraries/new_entry/'.$detail->id.'/prefecture');//都道府県選択画面を表示するweb.phpへ
    }
    
    public function prefecture_select(Area $area, Detail $detail)
    {
        //areaインスタンスのうち、(areaテーブルの)area_nameのうち、detailテーブル（選択したデータを格納するテーブル）のarea_nameと同じものを選択し、その一つ目を呼び出す（id情報も含まれている）。
        $select_prefecture = $area->where('area_name', $detail->area_name)->first();
       
        //$select_prefectureに含まれているareaデータのidを持つprefectureをgetしている。
        return view('itineraries/new_entry_prefecture')->with(['prefectures'=>$select_prefecture->prefectures()->get(), 'detail'=>$detail]);//地域選択画面を表示
    }
    
    public function prefecture_store(Request $request, Detail $detail)//出発都道府県を保存
    {
        $input_p = $request('prefecture_name');
        $detail->fill($input_p)->save();
        return redirect('itineraries/new_entry_railRoute');//出発駅選択画面を表示するweb.phpへ
    }
    
    
    
     public function show(Detail $itinerary)
    {
        return view('itineraries/show')->with(['detail' => $itinerary]);
    }
    
    
     public function new_entry_date()
    {
        return view('itineraries/new_entry_date');
    }




}
