<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class ProductRequest extends FormRequest
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

        if ($this->route('product'))
            $id = $this->route('product');

        return [
            'name.*' => "required|string",
            'category_id' => "required|exists:categories,id",
//            'vendor_id' => "required|exists:vendors,id",
            'price' => "required|numeric",
            'sample_order_price' => "required|numeric",
            'quantity' => "required|numeric",
            'image' => 'image|max:1048576',
            'status' => 'required|in:accepted,refused',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => trans("admin.general_validation.required"),
            '*.numeric' => trans("admin.general_validation.number"),
            "*.exists" => trans("admin.general_validation.exists"),
        ];
    }
}
