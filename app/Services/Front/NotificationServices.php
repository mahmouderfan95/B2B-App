<?php
namespace App\Services\Front;
use App\Http\Resources\Front\Notifications\GetAllDataResource;
use App\Traits\ApiResponseAble;

class NotificationServices{
    use ApiResponseAble;
    public function getAllNotifications()
    {
        $userAuth = auth('client')->user();
        $unreadNotification = $userAuth->unreadNotifications();
        return $this->ApiSuccessResponse(GetAllDataResource::collection($unreadNotification),'success message');
    }
}
