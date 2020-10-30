<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken(env('APP_NAME'))->accessToken;
            $success['user'] = $user;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] = $user->createToken(env('APP_NAME'))->accessToken;
        $success['user'] = $user;

        return response()->json(['success' => $success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function interactPost(Request $request)
    {
        # code...
    }

    public function uploadedPosts()
    {
        $user = Auth::user();
        $posts = $user->posts()->select(['id', 'pid', 'type'])->orderBy('id', 'desc')->simplePaginate(10);
        return response()->json($posts, $this->successStatus);
    }

    public function baggedPosts()
    {
        $postsBagged = Auth::user()->where('interact', 'bagged')->orderBy('id', 'desc')->select(['post_id'])->get()->toArray();

        $posts = Post::whereIn($postsBagged)->select(['id', 'pid', 'type'])->simplePaginate(10);
        return response()->json($posts, $this->successStatus);
    }
}
