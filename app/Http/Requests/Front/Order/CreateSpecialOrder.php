<?php

namespace App\Http\Requests\Front\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateSpecialOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vendor_id' => 'required|exists:vendors,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|numeric|exists:products,id',
            'items.*.qty' => 'required|numeric',
            'client_address_id' => 'required|exists:client_addresses,id',
            'date_from' => 'date_format:Y-m-d|before_or_equal:today',
            'date_to' => 'date_format:Y-m-d|after:date_from',
        ];
    }
}
