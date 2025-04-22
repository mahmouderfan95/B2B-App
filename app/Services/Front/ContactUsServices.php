<?php
namespace App\Services\Front;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use App\Helpers\FileUpload;
use App\Traits\ApiResponseAble;
use App\Http\Requests\Front\ContactUs\SendMessage;
use Exception;

class ContactUsServices{
    use FileUpload,ApiResponseAble;
    public function sendContactMessage(SendMessage $request)
    {
        $data_request = $request->except('file');
        if (isset($request->file))
            $data_request['file'] = $this->save_file($request->file, 'inquiries');
        try {
            $message = $this->storeMessage($data_request);
            if ($message)
                return $this->listResponse($message);
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

    private function storeMessage($data) {
        $message = Inquiry::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message_title' => $data['message_title'],
            'message_description' => $data['message_description']
        ]);
        return $message;
    }
}
