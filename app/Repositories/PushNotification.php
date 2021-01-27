<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Jobs\QueueNotification;
use App\Models\User;
use Carbon\Carbon;

class PushNotification extends Controller
{
    public function sendMail()
    {

        $details = [
            'greeting' => 'Bài bạn đã lưu để vô học',
            'body' => 'Dưới đây là dánh sách các bài mà bạn đã lưu, đã đến lúc quay lại để học tiếp nào.',
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
            $details['body'] = $list . "</ul>";

            QueueNotification::dispatch($user, $details);
        }
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
        return 'https://thatsgood.info/p/' . $type . '/' . $pid;
    }
}
