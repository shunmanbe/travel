<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailDateRequest extends FormRequest
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
            'initial_setting.departure_date' => 'required|date',
            'initial_setting.end_date' => 'required|date',
        ];
    }
    
    public function messages()
    {
        return [
            'initial_setting.title.required' => 'タイトルを入力してください',
            'initial_setting.departure_date.required' => '出発日を選択してください',
            'initial_setting.end_date.required' => '到着日を選択してください',
        ];
    }
}
