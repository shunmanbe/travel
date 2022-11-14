<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\User;
use App\Itinerary;
use App\Place;
use App\Share;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    // 所属しているグループ一覧を表示
    public function show_group(Group $group, Place $place)
    {
        $auth = Auth::user();
        $groups = Group::whereHas('users', function ($query) { 
            $query->where('users.id', auth()->id());
            })->get();
        return view('/itineraries/group/index')->with(['auth' => $auth, 'groups' => $groups, 'place' => $place]);
    }
    // グループを作成
    public function create_group()
    {
        $auth = Auth::user();
        $password = Str::random(15);
        return view('/itineraries/group/create_group')->with(['auth' => $auth, 'password' => $password]);
    }
    
    // 作成したグループを登録
    public function store_group(Request $request, Share $share, Group $group)
    {
        $auth = Auth::user();
        $input = $request['group'];
        $group->fill($input)->save();
        // ここから中間テーブルへの書き込み
        $user_id = $auth['id'];
        // 今保存したグループを取得（nameが先ほど送られてきたnameと一致するもの）
        $get_group = Group::where('name', $input['name'])->first(); //get()だと、ddした時に配列の階層が一つ増えるため、うまくいかない。
        // 中間テーブルにおいて、今のグループに登録したユーザーを追加（グループid:登録したグループのid にユーザーid:登録したユーザーのid を追加）
        $get_group->users()->attach($user_id);
        
        return redirect()->route('index.group');
    }
    
    public function itinerary_index(Share $share, Group $group)
    {
        $auth = Auth::user();
        return view('itineraries/group/itinerary_index')->with(['auth' => $auth, 'shares' => $share->where('group_id', $group->id)->get() ]);
    }
    
    public function new_entry(Share $share, Group $group)
    {
        $auth = Auth::user();
    }
    
    
    
    
}
