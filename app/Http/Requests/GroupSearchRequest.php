<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Group;
use Illuminate\Validation\Rule;

class GroupSearchRequest extends FormRequest
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
            'check.group_id' => 'required|exists:groups,group_id',
            'check.password' => 'required|exists:groups,password',
        ];
    }
    
    public function messages()
    {
        return [
            'check.group_id.required' => 'IDを入力してください',
            'check.group_id.exists' => 'IDが正しくありません', 
            'check.password.required' =>'パスワードを入力してください',
            'check.password.exists' => 'パスワードが正しくありません',
        ];
    }
}
