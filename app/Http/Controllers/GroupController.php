<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\User;
use App\Itinerary;
use App\ShareItinerary;
use App\Place;
use App\Http\Requests\GroupSearchRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    // 所属しているグループ一覧を表示
    public function index_group(Group $group, Place $place)
    {
        $auth = Auth::user();
        $groups = Group::whereHas('users', function ($query) { 
            $query->where('users.id', auth()->id());
            })->get();
        return view('/itineraries/group/group_index')->with(['auth' => $auth, 'groups' => $groups, 'place' => $place]);
    }
    
    // グループを作成
    public function create_group()
    {
        $auth = Auth::user();
        // idを作
        $group_id = random_int(100000, 999999); //random_intは 暗号論的に安全な疑似乱数を生成する。random_int(min, max)
        // パスワードを作成
        $password = Str::random(15);
        return view('/itineraries/group/create_group')->with(['auth' => $auth, 'group_id' => $group_id, 'password' => $password]);
    }
    
    // 作成したグループを登録
    public function store_group(Request $request, Group $group)
    {
        $auth = Auth::user();
        $input = $request['group'];
        $group->fill($input)->save();
        // ここから中間テーブルへの書き込み
        $user_id = $auth['id'];
        // 今保存したグループを取得（nameが先ほど送られてきたnameと一致するもの）
        $get_group = Group::where('group_id', $input['group_id'])->where('password', $input['password'])->first(); //get()だと、ddした時に配列の階層が一つ増えるため、うまくいかない。
        // 中間テーブルにおいて、今のグループに登録したユーザーを追加（グループid:登録したグループのid にユーザーid:登録したユーザーのid を追加）
        $get_group->users()->attach($user_id);
        
        return redirect()->route('group.index_group');
    }
    
    // グループを検索する
    public function search_group()
    {
        $auth = Auth::user();
        return view('itineraries/group/search_group')->with(['auth' => $auth]);
    }
    
    // グループに入るときにチェックする
    public function registration_check(GroupSearchRequest $request, Group $group)
    {
        $auth = Auth::user();
        // 送られてきた値をデータベースで検索
        $input = $request['check'];
        // idとパスワードが一致するグループをデータベースから取得
        $get_group = Group::where('group_id', $input['group_id'])->where('password', $input['password'])->first();
        // 取得したグループの名前を取り出す
        $group_name = $get_group['name'];
        // 参加グループを確認するページへ
        return view('/itineraries/group/confirm_group')->with(['auth' => $auth, 'group_name' => $group_name, 'get_group' => $get_group]);
    }
    
    // グループに登録する
    public function register_group(Request $request)
    {
        $auth = Auth::user();
        $input = $request['register'];
        
        $user_id = $auth['id'];
        // $get_groupにnameとpasswordが一致するものを代入
        $get_group = Group::where('name', $input['name'])->where('password', $input['password'])->first();
        // 中間テーブルに上で指定したグループのidとユーザーのidを追加
        $get_group->users()->attach($user_id);
        return redirect()->route('group.index_group');
    }
    
    // グループの情報を表示
    public function group_information(Group $group)
    {
        $auth = Auth::user();
        return view('/itineraries/group/group_information')->with(['auth' => $auth, 'group' => $group]);
    }
    // グループ情報を保存
    public function information_store(Request $request, Group $group)
    {
        $input = $request['information'];
        $group->fill($input)->save();
        return redirect()->route('group.index_group');
    }
    
    // グループを抜ける
    public function escape(Group $group)
    {
        $auth = Auth::user();
        $user_id = $auth['id'];
        $group->users()->detach($user_id);
        return redirect()->route('group.index_group');
    }
}