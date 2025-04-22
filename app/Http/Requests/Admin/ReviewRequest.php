<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'status' => 'required|in:accepted,pending,refused',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => trans("admin.general_validation.required"),/*
            'client_id.exists' => trans("admin.reviews.validations.image_required"),
            'product_id.exists' => trans("admin.reviews.validations.image_required"),*/
        ];
    }
}
