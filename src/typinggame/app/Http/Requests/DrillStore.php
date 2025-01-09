<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrillStore extends FormRequest
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
            'title' => ['required', 'max:50'],
            'category_id' => ['required'],
            'difficulty' => ['required'],
            'question1' => ['regex:/^[\x20-\x7e]*$/', 'required', 'max:70'],
            'question2' => ['regex:/^[\x20-\x7e]*$/', 'required', 'max:70'],
            'question3' => ['regex:/^[\x20-\x7e]*$/', 'required', 'max:70'],
            'question4' => ['regex:/^[\x20-\x7e]*$/', 'required', 'max:70'],
            'question5' => ['regex:/^[\x20-\x7e]*$/', 'required', 'max:70'],
            'question6' => ['regex:/^[\x20-\x7e]*$/', 'nullable', 'max:70'],
            'question7' => ['regex:/^[\x20-\x7e]*$/', 'nullable', 'max:70'],
            'question8' => ['regex:/^[\x20-\x7e]*$/', 'nullable', 'max:70'],
            'question9' => ['regex:/^[\x20-\x7e]*$/', 'nullable', 'max:70'],
            'question10' => ['regex:/^[\x20-\x7e]*$/', 'nullable', 'max:70'],
        ];
    }
}
