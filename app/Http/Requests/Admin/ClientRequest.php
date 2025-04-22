<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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

        if ($this->route('client'))
            $id = $this->route('client');

        return [
            'image' => 'image|max:1048576',
            'email' => "required|unique:clients,email,$id",
            'phone' => "sometimes|unique:clients,phone,$id",
            'another_phone' => "sometimes|different:phone|unique:clients,another_phone,$id",
            'status' => 'required|in:accepted,pending,refused',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => trans("admin.general_validation.required"),
        ];
    }
}
