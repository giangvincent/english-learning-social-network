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
            'subject' => 'required|max:255',
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
            'pid' => 'required',
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

        unlink(public_path('content/posts/') . $post->pid . '.json');
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
            $this->exportTag($tag);
        }
        $this->exportTags();
    }

    private function exportPost($post)
    {
        $this->CreateContentFol();
        // $authorData = $post->user()->first()->toArray();

        $exportData = array([
            'id' => $post->id,
            'url' => $post->pid,
            'subject' => $post->subject,
            'content' => json_decode($post->content, true),
            'author' => $post->user()->select(['id', 'nick_name', 'full_name', 'avatar'])->first()->toArray(),
            'category' => $post->categoryRelated()->select(['id', 'name', 'slug'])->first()->toArray(),
            'tags' => $post->tags()->select(['id', 'name', 'slug'])->get()->toArray(),
            'datetime' => $post->updated_at,
            'nums_bagged' => $post->nums_bagged,
            'nums_good' => $post->nums_good,
            'nums_bad' => $post->nums_bad,
            'nums_share' => $post->nums_share,
            'nums_comment' => $post->nums_comment,
            'interact' => array('bagged' => [], 'good' => [], 'bad' => []),
            'comments' => array(),
        ]);
        return file_put_contents(public_path('content/posts') . '/' . $post->pid . '.json', json_encode($exportData));
    }

    public function exportTag($tag)
    {
        $data = Tag::find($tag);
        $data = $data->toArray();

        file_put_contents(public_path() . '/content/tags/' . $tag->slug . '.json', json_encode($data));
    }

    public function exportTags()
    {
        $allTags = Tag::where('status', 'publish')->get();
        $allTagsData = [];
        foreach ($allTags as $tag) {
            $tagData = $tag->toArray();
            $tagData['posts'] = $tag->posts()->count();
            array_push($allTagsData, $tagData);
        }
        file_put_contents(public_path() . '/content/tags.json', json_encode($allTagsData));
    }
}
