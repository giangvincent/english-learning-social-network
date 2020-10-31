<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\userInteract;
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
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'interact' => 'required|in:bagged,good,bad,report,un-bagged,un-good,un-bad'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (strpos($request->interact, 'un-') !== false) {
            $interact = str_replace('un-', '', $request->interact);
            $success = userInteract::where([
                ['post_id', $request->post_id],
                ['user_id', Auth::user()->id],
                ['interact', $interact]
            ])->delete();
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $newInteract = new userInteract();
            $newInteract->post_id = $request->post_id;
            $newInteract->user_id = Auth::user()->id;
            $newInteract->interact = $request->interact;
            $newInteract->save();
            return response()->json(['success' => $newInteract], $this->successStatus);
        }
    }

    public function uploadedPosts()
    {
        $user = Auth::user();
        $posts = $user->posts()->select(['id', 'pid', 'type'])->orderBy('id', 'desc')->simplePaginate(10);
        return response()->json($posts, $this->successStatus);
    }

    public function baggedPosts()
    {
        $postsBagged = userInteract::where('user_id', Auth::user()->id)->where('interact', 'bagged')->orderBy('id', 'desc')->select(['post_id'])->get()->toArray();

        $posts = Post::whereIn('id', $postsBagged)->select(['id', 'pid', 'type'])->simplePaginate(10);
        return response()->json($posts, $this->successStatus);
    }
}
