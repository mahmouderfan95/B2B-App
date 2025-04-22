<?php

namespace App\Http\Requests\Front\Order\Special;

use Illuminate\Foundation\Http\FormRequest;

class SendShippingQuotationRequest extends FormRequest
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
            "shipping_method_id" => 'required|exists:shipping_methods,id',
            "special_order_id" => 'required|exists:special_orders,id',
            "quotation_price" => 'required',
            "expect_date_from" => 'required|date_format:Y-m-d|before_or_equal:today',
            "expect_date_to" => 'required|date_format:Y-m-d|after:expect_date_from',
        ];
    }
}
