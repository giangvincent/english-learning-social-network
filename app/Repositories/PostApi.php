<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\ExportJson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostApi extends Controller
{
    public function handleCreatePost($request)
    {
        $this->CreateUploadFol();
        $this->CreateContentFol();
        $request->content = $this->createAudios($request);

        $newPost = $this->newPostDB($request);
        if (!$newPost) {
            return response()->json(['status' => false], 200);
        }
        $this->attachTags($request->tags, $newPost);
        ExportJson::exportPost($newPost);
        return response()->json(['status' => true], 200);
    }

    public function handleUpdatePost($request, $post)
    {
        $updatePost = $this->changePostDB($request, $post);
        if (!$updatePost) {
            return response()->json(['status' => false], 200);
        }
        $post->tags()->detach();
        $this->attachTags($request->tags, $post);

        ExportJson::exportPost($post);
        return response()->json(['status' => true], 200);
    }

    public function handleDeletePost($post)
    {
        try {
            $this->removeMedias($post);
            $post->tags()->detach();

            @unlink(public_path('dist/content/posts/') . $post->pid . '.json');
            $post->interacts()->delete();
            $post->answers()->delete();
            $post->comments()->delete();
            $post->notifications()->delete();
            $post->progress()->delete();

            $post->delete();
            return response()->json(['status' => true], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json(['status' => false], 200);
        }
    }

    private static function removeMedias($post)
    {
        try {
            $postContent = json_decode($post->content, true);
            $medias = array();
            for ($paraIndex = 0; $paraIndex < count($postContent); $paraIndex++) {
                array_push($medias, $postContent[$paraIndex]['images']);
            }
            foreach ($medias as $media) {
                foreach ($media as $image) {
                    if (file_exists(public_path($image))) {
                        @unlink(public_path($image));
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    public static function attachTags($requestTags, $post)
    {
        try {
            $tags = json_decode($requestTags, true);
            for ($tagIndex = 0; $tagIndex < count($tags); $tagIndex++) {
                $tag = Tag::firstOrCreate([
                    'name' => Str::of($tags[$tagIndex])->lower(),
                    'slug' => Str::slug($tags[$tagIndex], '-'),
                    'status' => 'publish',
                ]);

                $post->tags()->attach($tag->id);
                ExportJson::exportTag($tag);
            }
            ExportJson::exportTags();
            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    private static function newPostDB($request)
    {
        try {
            $pid = (string) Str::uuid();
            $newPost = new Post();
            $newPost->pid = $pid;
            $newPost->subject = strip_tags($request->subject);
            $newPost->content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->content);
            $newPost->type = $request->post_type;
            $newPost->category = $request->cat_id;
            $newPost->author = Auth::user()->id;
            $newPost->save();
            return $newPost;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    private static function changePostDB($request, $post)
    {
        try {
            $post->subject = strip_tags($request->subject);
            $post->content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->content);
            $post->type = $request->post_type;
            $post->category = $request->cat_id;
            $post->save();
            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    public function createAudios($req)
    {
        $content = $request->content;
        $audios = array();
        foreach ($content as $para) {
            if (isset($para['audios'])) {
                # code...
                $audios[] = $para['audios'];
            }
        }

        foreach ($audios as $audio) {
            $audio_slug = Str::slug($audio[0]);
            $audio_path = public_path('dist/content/audios') . $audio_slug . '.mp3';
            if (!file_exists($audio_path)) {
                $audio_url = 'http://translate.google.com/translate_tts?ie=UTF-8&q='. urlencode($audio[0]) .'&tl=en&client=tw-ob';
                
                $fp = fopen($audio_path, 'w');
                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $audio_url);
                curl_setopt($handle, CURLOPT_FILE, $fp);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Referer: http://translate.google.com/',
                    'User-Agent: stagefright/1.2 (Linux;Android 5.0)'
                ));

                curl_exec($handle);
                curl_close($handle);
            }
        }

        return $content;
    }
}
