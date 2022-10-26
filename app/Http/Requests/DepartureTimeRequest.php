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
            'time_d.departure_time' => 'required|before:time_a.arrival_time',
        ];
    }
    
    public function messages()
    {
        return [
            'time_d.departure_time.required' => '日付を入力してください',
            'time_d.departure_time.before' =>'日付・時刻が正しくありません'
        ];
    }
}
