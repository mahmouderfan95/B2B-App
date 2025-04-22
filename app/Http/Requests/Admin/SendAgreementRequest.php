<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SendAgreementRequest extends FormRequest
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
            "vendor_id" => "required|exists:vendors,id",
            "agreement_pdf" => "required|mimes:pdf|max:3072"
        ];
    }

    public function attributes()
    {
        return [
            "vendor_id" => __('admin.vendors-agreements-keys.select-vendor'),
            "agreement_pdf" => __('admin.vendors-agreements-keys.agreement')
        ];
    }

    public function messages() {
        return [
            "agreement_pdf.mimes" => __('admin.vendors-agreements-keys.agreement-is-pdf'),
        ];
    }
}
