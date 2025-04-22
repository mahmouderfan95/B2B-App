<?php

namespace App\Http\Requests\Front\ContactUs;

use Illuminate\Foundation\Http\FormRequest;

class SendMessage extends FormRequest
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
            "full_name" => "required|string",
            "phone" => "required",
            "email" => "required|email",
            "message_title" => "required|string",
            "message_description" => "nullable|string",
            "file" => "nullable|file"
        ];
    }
}
