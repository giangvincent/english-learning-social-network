<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class FeedController extends Controller
{
    public $successStatus = 200;

    public function home()
    {
        $posts = Post::select(['id', 'pid', 'type'])->orderBy('id', 'desc')->simplePaginate(10);
        return response()->json($posts, $this->successStatus);
    }

    public function search($query)
    {
        $query = urldecode($query);
        $posts = Post::where('subject', 'LIKE', "%$query%")->select(['id', 'pid', 'type'])->orderBy('id', 'desc')->simplePaginate(10);
        return response()->json($posts, $this->successStatus);
    }

    public function feedCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->select(['id', 'pid', 'type'])->orderBy('id', 'desc')->simplePaginate(10);
        return response()->json($posts, $this->successStatus);
    }

    public function feedTag($slug)
    {
        $tag = Tag::with('posts')->where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->orderBy('id', 'desc')->simplePaginate(10)->toArray();
        for ($i = 0; $i < count($posts['data']); $i++) {
            $postData = array(
                'id' => $posts['data'][$i]['id'],
                'pid' => $posts['data'][$i]['pid'],
                'type' => $posts['data'][$i]['type'],
            );
            $posts['data'][$i] = $postData;
        }
        return response()->json($posts, $this->successStatus);
    }
}
