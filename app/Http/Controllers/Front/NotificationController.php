<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\Front\NotificationServices;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(public NotificationServices $notificationServices){}
    public function index()
    {
        return $this->notificationServices->getAllNotifications();
    }
}
