<?php

namespace App\Http\Requests\Front\Quotations;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateStatus extends FormRequest
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
            'status' => 'required|in:accepted,refused',
            'special_order_id' => 'required|exists:special_orders,id',
            'quotation_id' => 'required|exists:order_quotations,id'
        ];
    }
}
