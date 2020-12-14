<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\PostIDRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\PostApi;

class PostController extends Controller
{
    //
    public $successStatus = 200;
    public function CreatePost(CreatePostRequest $request)
    {
        $postApi = new PostApi();
        return $postApi->handleCreatePost($request);
    }

    public function updatePost(UpdatePostRequest $request)
    {
        $post = Post::where('pid', $request->pid)->firstOrFail();
        $postApi = new PostApi();
        return $postApi->handleUpdatePost($request, $post);
    }

    public function deletePost(PostIDRequest $request)
    {
        $post = Post::where('pid', $request->pid)->firstOrFail();

        $postApi = new PostApi();
        return $postApi->handleDeletePost($post);
    }

}
