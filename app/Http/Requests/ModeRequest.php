<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModeRequest extends FormRequest
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
    public function rules(Place $place)
    {
        //ここでtrueにする
        //渡されたplace以外はfalseにする？
        return [
            'Mode' => 'required'
        ];
    }
    
    public function messages()
    {
        return [
            'Mode.required' => '移動方法を選択してください',
        ];
    }
}
