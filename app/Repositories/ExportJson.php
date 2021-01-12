<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;

class ExportJson extends Controller
{
    public static function SaveNotification()
    {
        if (!file_exists(public_path('dist/content/notification'))) {
            mkdir(public_path('dist/content/notification'), 0777);
        }
        $users = User::all();
        foreach ($users as $user) {
            $notifyDB = $user->notify()->where([
                ['time_notification', Carbon::today()],
                ['seen', 0],
            ])->get();
            $notifyData = [];
            foreach ($notifyDB as $notify) {
                $data = [];
                $data = $notify->post()->select('pid', 'subject', 'type')->first();
                $data['date'] = $notify->time_notification;
                array_push($notifyData, $data);
            }

            file_put_contents(public_path('dist/content/notification') . '/' . $user->id . '.json', json_encode($notifyData));
        }
    }

    public static function SaveLearningProgress()
    {
        if (!file_exists(public_path('dist/content/learn_progress'))) {
            mkdir(public_path('dist/content/learn_progress'), 0777);
        }

        $users = User::all();
        foreach ($users as $user) {
        }
    }

    public static function exportPost($post)
    {

        // $authorData = $post->user()->first()->toArray();
        $interacts = $post->interacts()->get();
        $interactsArr = array('bagged' => [], 'good' => [], 'bad' => []);
        foreach ($interacts as $interactDb) {
            array_push($interactsArr[$interactDb->interact], $interactDb->user_id);
        }

        $exportData = array([
            'id' => $post->id,
            'url' => $post->pid,
            'subject' => $post->subject,
            'content' => json_decode($post->content, true),
            'author' =>
            $post->user()->select(['id', 'nick_name', 'full_name', 'avatar'])->first()->toArray(),
            'category' =>
            $post->categoryRelated()->select(['id', 'name', 'slug'])->first()->toArray(),
            'tags' =>
            $post->tags()->select(['id', 'name', 'slug'])->get()->toArray(),
            'type' => $post->type,
            'datetime' => $post->updated_at,
            'nums_bagged' => $post->nums_bagged,
            'nums_good' => $post->nums_good,
            'nums_bad' => $post->nums_bad,
            'nums_share' => $post->nums_share,
            'nums_comment' => $post->nums_comment,
            'interact' => $interactsArr,
            'comments' => array(),
        ]);
        return file_put_contents(public_path('dist/content/posts') . '/' . $post->pid . '.json', json_encode($exportData));
    }

    public static function exportTag($tag)
    {
        $data = Tag::find($tag);
        $data = $data->toArray();

        file_put_contents(public_path() . '/dist/content/tags/' . $tag->slug . '.json', json_encode($data));
    }

    public static function exportTags()
    {
        $allTags = Tag::where('status', 'publish')->get();
        $allTagsData = [];
        foreach ($allTags as $tag) {
            $tagData = $tag->toArray();
            $tagData['posts'] = $tag->posts()->count();
            array_push($allTagsData, $tagData);
        }
        file_put_contents(public_path() . '/dist/content/tags.json', json_encode($allTagsData));
    }
}
