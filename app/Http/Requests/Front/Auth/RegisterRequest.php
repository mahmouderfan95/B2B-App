<?php

namespace App\Http\Requests\Front\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'    => 'required|email|unique:clients,email',
            'password' => 'required|min:6',
            // 'name'     => 'required|min:3',
            // 'phone'           => ['nullable','unique:clients,phone'],
            // 'another_phone'   => ['nullable','unique:clients,another_phone'],
            // 'zip_code'        => ['nullable'],
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
