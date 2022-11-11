<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    // ここから下はgoogleアカウントでのログイン処理
    public function redirectToGoogle()
    {
        // Googleへのリダイレクト
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // Google 認証後の処理
        $googleUser = Socialite::driver('google')->stateless()->user();
        dd($gUser);
        // emailが合致するユーザーを取得
        $user = User::where('email', $googleUser->email)->first();
        // 見つからなければ新しくユーザーを作成
        if ($user == null){
            $user = $this->createUserByGoogle($googleUser);
        }
        // ログイン処理
        \Auth::login($user, true);
        return redirect('\home');
    }
    
    public function createUserByGoogle($googleUser)
    {
        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => \Hash::make(uniqid()),
        ]);
        return $user;
    }
    
    
}
