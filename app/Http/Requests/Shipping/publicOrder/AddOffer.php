<?php

namespace App\Http\Requests\Shipping\publicOrder;

use Illuminate\Foundation\Http\FormRequest;

class AddOffer extends FormRequest
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
            'price' => 'required|numeric',
            'order_id' => 'required|exists:orders,id',
            'expect_date_from' => 'required|date',
            'expect_date_to' => 'required|date',
        ];
    }
}
