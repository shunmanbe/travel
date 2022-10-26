<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItineraryDateRequest extends FormRequest
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
            'initial_setting.title' => 'required|string|max:30',
            'initial_setting.departure_date' => 'required',
            'initial_setting.arrival_date' => 'required|date|after:initial_setting.departure_date',
        ];
    }
    
    public function messages()
    {
        return [
            'initial_setting.title.required' => 'タイトルを入力してください',
            'initial_setting.departure_date.required' => '出発日を選択してください',
            'initial_setting.arrival_date.required' => '到着日を選択してください',
            'initial_setting.arrival_date.after' => '到着日が正しくありません',
        ];
    }
}
