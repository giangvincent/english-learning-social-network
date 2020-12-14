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

            @unlink(public_path('content/posts/') . $post->pid . '.json');
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
            $newPost->subject = $request->subject;
            $newPost->content = $request->content;
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
            $post->subject = $request->subject;
            $post->content = $request->content;
            $post->type = $request->post_type;
            $post->category = $request->cat_id;
            $post->save();
            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }

    }
}
