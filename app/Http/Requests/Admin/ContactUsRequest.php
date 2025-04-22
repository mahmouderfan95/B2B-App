<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'email'          => "nullable|email",
            "phone"          => "numeric",
            'work_time'      => "nullable|string",
            'facebook_link'  => "nullable|url",
            'instagram_link' => "nullable|url",
            'twitter_link'   => "required|url",
            'whatsapp_link'  => "required|url",
            'address.*'      => "required|string",


        ];
    }

    public function messages()
    {
        return [
            'name.*.required' => trans("admin.aboutUss.validations.name_required"),
        ];
    }
}
