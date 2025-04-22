<?php

namespace App\Http\Requests\Front\SpOrder;

use Illuminate\Foundation\Http\FormRequest;

class SendQuotation extends FormRequest
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
            'special_order_id' => 'required|exists:special_orders,id',
            'order_quotation_id' => 'required|exists:order_quotations,id',
            'quotation_price' => 'required|numeric',
            'expect_date_from' => 'required|date',
            'expect_date_to' => 'required|date'
        ];
    }
}
