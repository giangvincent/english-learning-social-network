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

        $postContent = json_decode($request->content, true);
        $medias = array();
        $contentHtml = array();
        for ($paraIndex = 0; $paraIndex < count($postContent); $paraIndex++) {
            array_push($contentHtml, $postContent[$paraIndex]['contentHtml']);
            array_push($medias, $postContent[$paraIndex]['images']);
        }
        $textOnly = Str::limit(strip_tags(implode("-", $contentHtml)), 100);

        $pid = (string) Str::uuid();
        $newPost = new Post();
        $newPost->pid = $pid;
        $newPost->url = Str::slug($textOnly, "-") . '-' . $pid;
        $newPost->content = $request->content;
        $newPost->medias = json_encode($medias);
        $newPost->type = $request->post_type;
        $newPost->category = $request->cat_id;
        $newPost->author = Auth::user()->id;
        $newPost->save();

        $tags = json_decode($request->tags, true);
        for ($tagIndex = 0; $tagIndex < count($tags); $tagIndex++) {

            $tag = Tag::firstOrCreate([
                'name' => $tags[$tagIndex],
                'slug' => Str::slug($tags[$tagIndex], '-'),
                'status' => 'publish',
            ]);
            dump($tag);
            $newPost->tags()->attach($tag->id);
        }

        return response()->json(['success' => $request->all()], $this->successStatus);
    }

    public function CreateUploadFol()
    {
        if (!file_exists(public_path('upload'))) {
            mkdir(public_path('upload'), 0777);
        }
        if (!file_exists(public_path('upload/post'))) {
            mkdir(public_path('upload/post'), 0777);
        }
        if (!file_exists(public_path('upload/temp'))) {
            mkdir(public_path('upload/temp'), 0777);
        }
    }
}
