<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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

        if ($this->route('category'))
            $id = $this->route('category');

        return [
            'name.*' => "required|string",
            'parent_id' => 'nullable|numeric|exists:categories,id',
            'image' => 'image|max:1048576',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => trans("admin.categories.validations.name_ar_required"),
            "parent_id.numeric" => trans("admin.categories.validations.parent_id_numeric"),
            "parent_id.exists" => trans("admin.categories.validations.parent_id_exists"),
        ];
    }
}
