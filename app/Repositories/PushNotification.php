<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Jobs\QueueNotification;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class PushNotification extends Controller
{
    public static function sendMail()
    {
        $details = [
            'greeting' => 'Bài bạn đã lưu để vô học',
            'body' => '',
            /* 'actionText' => 'View My Site',
        'actionURL' => url('/'),
        'order_id' => 101, */
        ];

        $users = User::all();
        foreach ($users as $user) {
            $notifyDB = $user->notify()->where([
                ['time_notification', Carbon::today()],
                ['seen', 0],
            ])->get();
            if (count($notifyDB) <= 0) {
                continue;
            }
            $list = '<ul>';
            foreach ($notifyDB as $notify) {
                $data = [];
                $data = $notify->post()->select('pid', 'subject', 'type')->first();

                $list .= '<li><a href="' . self::createUrl($data->type, $data->pid) . '" target="_blank">' . $data->subject . '</a></li>';
            }
            $details['body'] .= $list . "</ul>";

            QueueNotification::dispatch($user, $details);
        }
    }

    public static function testMail()
    {
        $details = [
            'greeting' => 'Bài bạn đã lưu để vô học',
            'body' => '',
            /* 'actionText' => 'View My Site',
        'actionURL' => url('/'),
        'order_id' => 101, */
        ];

        $user = User::first();
        $post = Post::first();
        $list = '<ul>';
        $list .= '<li><a href="' . self::createUrl($post->type, $post->pid) . '" target="_blank">' . $post->subject . '</a></li>';
        $details['body'] = $list . "</ul>";

        QueueNotification::dispatch($user, $details);
    }

    public static function createUrl($ptype, $pid)
    {
        $type = 'post';
        if ($ptype == 'flashCard') {
            $type = 'flash-card';
        }
        if ($ptype == 'quiz') {
            $type = 'quiz';
        }
        return 'https://thatsgood.info/p/' . $type . '/' . $pid . '?from=notification';
    }
}
