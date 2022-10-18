<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //filter：平仮名、カタカナ、漢字が不可。@の後にドットが最低一つ必要。
            //dns：メールアドレスのドメインが存在するかチェック
            'email' => 'required|email',
            'title' => 'required',
            'body' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'email.required' => 'メールアドレスが入力されていません',
            'email.email' => 'メールアドレスが正しくありません',
            'title.required' => 'タイトルが入力されていません',
            'body.required' => 'お問い合わせ内容が入力されていません。',
        ];
    }
}
