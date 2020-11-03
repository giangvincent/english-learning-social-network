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
        $user = Auth::user()->toArray();
        $userInfo = Auth::user()->info()->first()->toArray();
        unset($userInfo['id']);
        unset($userInfo['user_id']);

        return response()->json(['success' => array_merge($user, $userInfo)], $this->successStatus);
    }

    public function updateInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:200',
            'nick_name' => 'required|max:200',
            'bio' => 'required|max:500',
            'birthday' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = Auth::user();

        $user->full_name = $request->full_name;
        $user->nick_name = $request->nick_name;
        $user->birthday = $request->birthday;
        $user->save();

        $userInfo = Auth::user()->info()->first();
        $userInfo->bio = $request->bio;
        $userInfo->save();

        return response()->json(['success' => 1], $this->successStatus);
    }

    public function changeAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $user = Auth::user();
        $user->avatar = $request->avatar;
        $user->save();

        return response()->json(['success' => 1], $this->successStatus);
    }
    public function changeCover(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cover_image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $userInfo = Auth::user()->info()->first();
        $userInfo->cover_image = $request->cover_image;
        $userInfo->save();

        return response()->json(['success' => 1], $this->successStatus);
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cur_password' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $newPassword = bcrypt($request->password);
        $user = Auth::user();
        $user->password = $newPassword;
        $user->save();
        return response()->json(['success' => 1], $this->successStatus);
    }

    public function updateNotificationConn()
    {
        # code...
    }

    public function interactPost(Request $request)
    {
        $allowInteract = array("bagged", "good", "bad", "report", "un-bagged", "un-good", "un-bad");
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'interact' => 'required|in:' . implode(',', $allowInteract),
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $post = Post::where('id', $request->post_id)->first();

        if (strpos($request->interact, 'un-') !== false) {
            $success = $this->handleRemoveInteract($request);
            $this->impactPostData($post, 'decrement', $request->interact);
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $newInteract = $this->handleAddInteract($request);
            $this->impactPostData($post, 'increment', $request->interact);
            return response()->json(['success' => $newInteract], $this->successStatus);
        }
    }

    public function handleRemoveInteract($request)
    {
        $interact = str_replace('un-', '', $request->interact);
        $success = userInteract::where([
            ['post_id', $request->post_id],
            ['user_id', Auth::user()->id],
            ['interact', $interact],
        ])->delete();

        return $success;
    }

    public function handleAddInteract($request)
    {
        $newInteract = new userInteract();
        $newInteract->post_id = $request->post_id;
        $newInteract->user_id = Auth::user()->id;
        $newInteract->interact = $request->interact;
        $newInteract->save();

        return $newInteract;
    }

    public function impactPostData($post, $impactType, $reqInteract)
    {
        $interact = str_replace('un-', '', $reqInteract);
        $postJsonData = file_get_contents(public_path('content/posts') . '/' . $post->pid . '.json');
        $postJsonData = json_decode($postJsonData, true);

        if ($impactType === 'decrement') {
            $dbSaved = $post->decrement('nums_' . $interact);
            $postJsonData[0]['nums_' . $interact] = ($postJsonData[0]['nums_' . $interact] > 1) ? $postJsonData[0]['nums_' . $interact]-- : 0;
            array_diff($postJsonData[0]['interact'][$interact], array(Auth::user()->id));
        }

        if ($impactType === 'increment') {
            $dbSaved = $post->increment('nums_' . $interact);
            $postJsonData[0]['nums_' . $interact] = ($postJsonData[0]['nums_' . $interact] !== null) ? $postJsonData[0]['nums_' . $interact]++ : 1;
            array_push($postJsonData[0]['interact'][$interact], Auth::user()->id);
        }

        return file_put_contents(public_path('content/posts') . '/' . $post->pid . '.json', json_encode($postJsonData));
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
