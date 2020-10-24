<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
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
        $this->exportPost($newPost);
        return response()->json(['success' => $request->all()], $this->successStatus);
    }

    public function updatePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'pid' => 'required',
            'cat_id' => 'required',
            'post_type' => 'required',
            'content' => 'required',
            'tags' => '',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $post = Post::firstOrFail($request->id);
        if ($post->pid !== $request->pid) {
            return response()->json(['error' => 'Your request has been refused.'], 401);
        }
        $this->changePostDB($request, $post);
        $post->tags()->detach();
        $this->attachTags($request->tags, $post);

        $this->exportPost($post);
        return response()->json(['success' => $request->all()], $this->successStatus);
    }

    public function deletePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'pid' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $post = Post::firstOrFail($request->id);
        if ($post->pid !== $request->pid) {
            return response()->json(['error' => 'Your request has been refused.'], 401);
        }
        $this->removeMedias($post);
        $post->tags()->detach();
        
        unlink(public_path('content/posts/'). $post->pid .'.json');
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
            if (file_exist(public_path($media))) {
                unlink(public_path($media));
            }
        }
    }

    private function newPostDB($request)
    {
        $pid = (string) Str::uuid();
        $newPost = new Post();
        $newPost->pid = $pid;
        $newPost->content = $request->content;
        $newPost->type = $request->post_type;
        $newPost->category = $request->cat_id;
        $newPost->author = Auth::user()->id;
        $newPost->save();
        return $newPost;
    }

    private function changePostDB($request, $post)
    {
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
                'name' => $tags[$tagIndex],
                'slug' => Str::slug($tags[$tagIndex], '-'),
                'status' => 'publish',
            ]);
            $post->tags()->attach($tag->id);
        }
    }

    private function exportPost($post)
    {
        $this->CreateContentFol();
        // $authorData = $post->user()->first()->toArray();

        $exportData = array([
            'id' => $post->id,
            'url' => $post->pid,
            'content' => json_decode($post->content, true),
            'author' => $post->user()->first()->toArray(),
            'category' => $post->category()->first()->toArray(),
            'tags' => $post->tags()->get()->toArray(),
            'datetime' => $post->updated_at,
            'nums_pocket' => $post->nums_pocket,
            'nums_good' => $post->nums_good,
            'nums_bad' => $post->nums_bad,
            'nums_share' => $post->nums_share,
            'nums_comment' => $post->nums_comment,
        ]);

        return file_put_contents(public_path('content/posts') . $post->pid . '.json', json_encode($exportData));
    }
}
