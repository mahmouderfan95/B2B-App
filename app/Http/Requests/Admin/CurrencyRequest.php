<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyRequest extends FormRequest
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
        $id = 0;

        if ($this->route('language'))
            $id = $this->route('language');

        return [
            'name' => "required|string|min:2|max:191",
            'code' => "required",
            'value' => "required",
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            "name.required" => trans("admin.currencies.validations.name_required"),
            "code.required" => trans("admin.currencies.validations.code_required"),
            "value.required" => trans("admin.currencies.validations.value_required"),
        ];
    }
}
