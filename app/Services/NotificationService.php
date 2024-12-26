<?php

namespace App\Services;

use App\Events\StoreNotificationEvent;
use App\Models\Notification;

class NotificationService
{
    public static function store($message, $title, $id = null)
    {
        $notification = Notification::create([
            'title' => $title,
            'user_id' => $id ? $id : $message->user_id,
            'url' => route('themes.show', $message->theme_id) . '#' . $message->id,
        ]);

        event(new StoreNotificationEvent($notification));
    }
}
