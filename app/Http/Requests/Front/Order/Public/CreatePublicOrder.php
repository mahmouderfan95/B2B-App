<?php

namespace App\Http\Requests\Front\Order\Public;

use Illuminate\Foundation\Http\FormRequest;

class CreatePublicOrder extends FormRequest
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
            'items' => 'array|max:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric',
            'address_id' => 'required|exists:client_addresses,id',
        ];
    }

    public function messages()
    {
        return [
            "*.exists"  => trans("admin.general_validation.unavailable"),
            '*.required' => trans("admin.general_validation.required"),
            '*.numeric' => trans("admin.general_validation.number"),
            '*.date' => trans("admin.general_validation.date"),
        ];
    }
}
