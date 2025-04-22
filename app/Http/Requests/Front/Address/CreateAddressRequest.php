<?php

namespace App\Http\Requests\Front\Address;

use Illuminate\Foundation\Http\FormRequest;

class CreateAddressRequest extends FormRequest
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
            'country_id'   => 'required|exists:countries,id',
            // 'region_id'   => 'required|exists:regions,id',
            'city_id'     => 'required|exists:cities,id',
            'address'     => 'required|min:3',
            'first_name'  => 'required|min:3',
            'last_name'   => 'nullable|min:3',
            "zip_code"    => 'nullable',
            "Port_details"   => 'nullable',
            "shipping_method"   => 'required',
            'address'     => 'required|min:3',
            'phone'       => 'nullable',
            'is_default'  => 'nullable|boolean',
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
