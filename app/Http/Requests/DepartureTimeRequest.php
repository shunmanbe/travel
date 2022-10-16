<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartureTimeRequest extends FormRequest
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
            'time.departure_time' => 'required',
        ];
    }
    
     public function messages()
    {
        return [
            'time.departure_time.required' => '出発日時を入力してください',
        ];
    }
}
