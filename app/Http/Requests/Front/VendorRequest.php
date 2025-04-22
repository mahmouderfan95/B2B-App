<?php

namespace App\Http\Requests\Front;

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
            'country_id' => 'required|numeric|exists:countries,id',
            'bank_id' => 'required|numeric|exists:banks,id',
            'name' => 'required',
            'web_site'     => 'nullable',
            'vendor_name'  => 'required',
            'accept_terms' => 'boolean',
            'street' => 'required',
            'bank_account_number' => 'required|numeric',
            'iban' => 'required|string|regex:/^[^\s]+$/',
            'phone' => 'required|unique:vendors,phone',
            'another_phone' => 'required|different:phone|unique:vendors,another_phone',
            'email' => 'required|email',
            'description' => 'required',
            'commercial_registration_number' => 'required|numeric',
            'expire_date_commercial_registration' => 'required|date|after:now',
            'logo' => 'required|image|max:1048576',
            'image_commercial' => 'required|image|max:1048576',
            'image_iban' => 'required|image|max:1048576',
            'image_mark' => 'required|image|max:1048576',
            'image_tax' => 'required|image|max:1048576',
            'password' => "required|regex:/[^\s]/",
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
