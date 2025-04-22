<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'country_id' => 'required|numeric',
            'bank_id' => 'required|numeric',
            'name' => 'required',
            'street' => 'required',
            'bank_account_number' => 'required|numeric',
            'iban' => 'required|string',
            'phone' => 'required',
            'another_phone' => 'required',
            'email' => 'required',
            'description' => 'required',
            'commercial_registration_number' => 'required|numeric',
            'expire_date_commercial_registration' => 'required|date',
            'logo' => 'image|max:1048576',
            'image_commercial' => 'image|max:1048576',
            'image_iban' => 'image|max:1048576',
            'image_mark' => 'image|max:1048576',
            'image_tax' => 'image|max:1048576',
            'status' => 'required',
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
