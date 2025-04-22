<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'name.*' => "required|string",
            'sort_order' => "required|numeric",
        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => trans("admin.units.validations.name_required"),
            'sort_order.required' => trans("admin.units.validations.sort_order_required"),
        ];
    }
}
