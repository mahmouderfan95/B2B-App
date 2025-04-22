<?php

namespace App\Http\Requests\Front\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CompleteProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [

            "name"          => 'nullable|min:3',
            'phone'         => 'nullable|min:8',
            'another_phone' => 'nullable|different:phone|min:8',
            'zip_code'      => "nullable|min:3"
        ];
    }

    public function messages()
    {
        return [
            '*.required' => trans("admin.general_validation.required"),
            '*.numeric' => trans("admin.general_validation.number"),
            '*.date' => trans("admin.general_validation.date"),
        ];
    }
}
