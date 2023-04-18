<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return NotificationResource::collection(Auth::user()->notifications()->paginate());
    }

    public function markAllAsRead()
    {
        return Auth::user()->unreadNotifications->markAsRead();
    }

    public function markAsRead(Notification $notification): NotificationResource
    {
        return new NotificationResource(tap($notification)->markAsRead());
    }
}
