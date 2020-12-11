<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\ExportJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

class PostController extends Controller
{
    //
    public $successStatus = 200;
    public function CreatePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required',
            'post_type' => 'required',
            'subject' => 'required|max:255',
            'content' => 'required',
            'user' => 'required',
            'tags' => '',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $this->CreateUploadFol();

        $newPost = $this->newPostDB($request);
        $this->attachTags($request->tags, $newPost);

        $this->CreateContentFol();
        ExportJson::exportPost($newPost);
        return response()->json(['success' => $request->all()], $this->successStatus);
    }

    public function updatePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
            'cat_id' => 'required',
            'post_type' => 'required',
            'subject' => 'required|max:255',
            'content' => 'required',
            'tags' => '',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $post = Post::where('pid', $request->pid)->firstOrFail();

        $this->changePostDB($request, $post);
        $post->tags()->detach();
        $this->attachTags($request->tags, $post);
        $this->CreateContentFol();
        ExportJson::exportPost($post);
        return response()->json(['success' => $request->all()], $this->successStatus);
    }

    public function deletePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $post = Post::where('pid', $request->pid)->firstOrFail();

        $this->removeMedias($post);
        $post->tags()->detach();

        @unlink(public_path('content/posts/') . $post->pid . '.json');
        $post->interacts()->delete();
        $post->answers()->delete();
        $post->comments()->delete();
        $post->notifications()->delete();
        $post->progress()->delete();

        $post->delete();

        return response()->json(['success' => 'Post deleted successfully.'], $this->successStatus);
    }

    private function removeMedias($post)
    {
        $postContent = json_decode($post->content, true);
        $medias = array();
        for ($paraIndex = 0; $paraIndex < count($postContent); $paraIndex++) {
            array_push($medias, $postContent[$paraIndex]['images']);
        }
        foreach ($medias as $media) {
            foreach ($media as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }
    }

    private function newPostDB($request)
    {
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
    }

    private function changePostDB($request, $post)
    {
        $post->subject = $request->subject;
        $post->content = $request->content;
        $post->type = $request->post_type;
        $post->category = $request->cat_id;
        $post->save();
    }

    private function filterBadWords()
    {
    }

    protected function attachTags($requestTags, $post)
    {
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
    }

}
