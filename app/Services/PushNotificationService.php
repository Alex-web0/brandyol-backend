<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class PushNotificationService
{
    static public function sendPushNotification(User $toUser, string $title, string $body, int $order_id = null,  bool $condition = true, string $image_url = null,)
    {
        if (!$condition) return;
        $user = $toUser;

        // dd($user);

        $appleToken = $user->ios_token;
        $androidToken = $user->android_token;
        $webToken = $user->web_token;

        $tokens = [];

        if (!empty($appleToken)) $tokens = [...$tokens, $appleToken];
        if (!empty($androidToken)) $tokens = [...$tokens, $androidToken];
        if (!empty($webToken)) $tokens = [...$tokens, $webToken];

        $firebase = (new Factory)
            ->withServiceAccount(__DIR__ . '/../../config/firebase-config.json');

        $messaging = $firebase->createMessaging();



        $message = CloudMessage::fromArray([
            'priority' => 'high',
            'notification' => [
                'title' => $title,
                'body' => $body,
                'image' => $image_url
            ],
            'data' => [
                'type' => 'status_update'
            ]
        ]);

        // send to all this users' devices
        $messaging->sendMulticast($message, $tokens);


        // store notification
        // todo: add images
        $t =  Notification::create([
            'title' => $title,
            'body' => $body,
            'order_id' => $order_id,
            'user_id' =>  $user->id,
        ]);

        // $t->save();

        // dd($t);


        return null;
    }
}
