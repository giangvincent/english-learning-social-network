<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;

class ExportJson
{
    public function SaveNotification()
    {
        if (!file_exists(public_path('content/notification'))) {
            mkdir(public_path('content/notification'), 0777);
        }
        $users = User::all();
        foreach ($users as $user) {

            $notifyDB = $user->notify()->where([
                ['time_notification', '<=', Carbon::today()],
                ['seen', 0],
            ])->get();
            $notifyData = [];
            foreach ($notifyDB as $notify) {
                $data = [];
                $data = $notify->post()->select('pid', 'subject', 'type')->first();
                $data['date'] = $notify->time_notification;
                array_push($notifyData, $data);
            }

            file_put_contents(public_path('content/notification') . '/' . $user->id . '.json', json_encode($notifyData));
        }
    }
}
