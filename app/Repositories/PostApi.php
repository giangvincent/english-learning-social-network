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
        $content = $this->createAudios($request);

        $newPost = $this->newPostDB($request, $content);
        if (!$newPost) {
            return response()->json(['status' => false], 200);
        }
        $this->attachTags($request->tags, $newPost);
        ExportJson::exportPost($newPost);
        return response()->json(['status' => true], 200);
    }

    public function handleUpdatePost($request, $post)
    {
        $content = $this->createAudios($request);
        $updatePost = $this->changePostDB($request, $post, $content);
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

    private static function newPostDB($request, $content)
    {
        try {
            $pid = (string) Str::uuid();
            $newPost = new Post();
            $newPost->pid = $pid;
            $newPost->subject = strip_tags($request->subject);
            $newPost->content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
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

    private static function changePostDB($request, $post, $content)
    {
        try {
            $post->subject = strip_tags($request->subject);
            $post->content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
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
        $content = json_decode($req->content, true);
        for ($i = 0; $i < count($content); $i++) {
            if (
                isset($content[$i]['audios']) &&
                count($content[$i]['audios']) > 0
            ) {
                $audios = $content[$i]['audios'];
                $audio_slug = Str::slug($audios[0]);
                $audio_path = public_path('dist/content/audios') . '/' . $audio_slug . '.mp3';

                if (!file_exists($audio_path)) {
                    self::saveAudioFromGoogleTranslate($audios[0], $audio_path);
                }
                $content[$i]['audios'][0] = '/content/audios/' . $audio_slug . '.mp3';
            }

            if (
                isset($content[$i]['flipAudios']) &&
                count($content[$i]['flipAudios']) > 0
            ) {
                $audios = $content[$i]['flipAudios'];
                $audio_slug = Str::slug($audios[0]);
                $audio_path = public_path('dist/content/audios') . '/' . $audio_slug . '.mp3';

                if (!file_exists($audio_path)) {
                    self::saveAudioFromGoogleTranslate($audios[0], $audio_path);
                }
                $content[$i]['flipAudios'][0] = '/content/audios/' . $audio_slug . '.mp3';
            }
        }
        return json_encode($content);
    }

    public static function saveAudioFromGoogleTranslate($text, $audio_path)
    {
        $audio_url = 'http://translate.google.com/translate_tts?ie=UTF-8&q=' . urlencode($text) . '&tl=en&client=tw-ob';

        $fp = fopen($audio_path, 'w+');
        try {

            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $audio_url);
            curl_setopt($handle, CURLOPT_FILE, $fp);
            curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                'Referer: http://translate.google.com/',
                'User-Agent: stagefright/1.2 (Linux;Android 5.0)',
            ));

            curl_exec($handle);
            curl_close($handle);
            fclose($fp);
            return 'saved.';
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
