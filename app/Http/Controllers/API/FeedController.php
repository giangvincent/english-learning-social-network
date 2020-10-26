<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;

class FeedController extends Controller
{
    public $successStatus = 200;

    public function home()
    {
        $posts = Post::select(['id', 'pid', 'type'])->orderBy('id', 'desc')->simplePaginate(10);
        return response()->json($posts, $this->successStatus);
    }

}
