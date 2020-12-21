<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\userInteract;
use App\Models\UserNotification;
use App\Models\UserProgress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            $userInfo = $user->info()->first()->toArray();
            unset($userInfo['id'], $userInfo['user_id']);
            $success['user'] = array_merge($user->toArray(), $userInfo);
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
            'full_name' => 'required|max:255',
            'nick_name' => 'max:255',
            'birthday' => 'date',
            'email' => 'required|email|max:191',
            'password' => 'required|max:191',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $userInfo = $user->info()->create();

        $success['token'] = $user->createToken(env('APP_NAME'))->accessToken;
        $success['user'] = $user;

        return response()->json(['success' => $success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {

        $user = User::with('info')->where('id', $id)->firstOrFail();

        $userArray = $user->toArray();
        $returnArr = array(
            'full_name' => $userArray['full_name'],
            'nick_name' => $userArray['nick_name'],
            'avatar' => $userArray['avatar'],
            'bio' => $userArray['info']['bio'],
            'cover_image' => $userArray['info']['cover_image'],
        );

        return response()->json(['success' => $returnArr], $this->successStatus);
    }

    public function uploadedPosts($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->select(['id', 'pid', 'type'])->orderBy('id', 'desc')->simplePaginate(10);

        return response()->json($posts, $this->successStatus);
    }

    public function updateInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|max:200',
            'nick_name' => 'max:200',
            'bio' => 'max:500',
            'birthday' => 'date',
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

        if (!$this->validateBaseImg($request->avatar)) {
            $res = [
                'success' => false,
                'message' => 'Validate failed: Image error',
            ];
            return response()->json($res);
        }

        list($extension, $content) = explode(';', $request->avatar);
        $fileName = 'user/avatar-' . Auth::user()->id . '.' . explode('/', $extension)[1];
        $content = explode(',', $content)[1];
        $storage = Storage::disk('public');

        $storage->put($fileName, base64_decode($content), 'public');

        $user = Auth::user();
        $user->avatar = '/upload/' . $fileName;
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
        if (!$this->validateBaseImg($request->cover_image)) {
            $res = [
                'success' => false,
                'message' => 'Validate failed: Image error',
            ];
            return response()->json($res);
        }

        list($extension, $content) = explode(';', $request->cover_image);
        $fileName = 'user/cover-' . Auth::user()->id . '.' . explode('/', $extension)[1];
        $content = explode(',', $content)[1];
        $storage = Storage::disk('public');

        $storage->put($fileName, base64_decode($content), 'public');

        $userInfo = Auth::user()->info()->first();
        $userInfo->cover_image = '/upload/' . $fileName;
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
            'post_id' => 'required|exists:posts,pid',
            'interact' => 'required|in:' . implode(',', $allowInteract),
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $post = Post::where('pid', $request->post_id)->first();

        if (strpos($request->interact, 'un-') !== false) {
            $success = $this->handleRemoveInteract($post, $request);
            $this->impactPostData($post, 'decrement', $request);
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $newInteract = $this->handleAddInteract($post, $request);
            $this->impactPostData($post, 'increment', $newInteract);
            if ($request->interact === 'bagged') {
                $this->calculateLearningDay($post);
            }
            return response()->json(['success' => $newInteract], $this->successStatus);
        }
    }

    public function handleRemoveInteract($post, $request)
    {
        $interact = str_replace('un-', '', $request->interact);
        $success = userInteract::where([
            ['post_id', $post->id],
            ['user_id', Auth::user()->id],
            ['interact', $interact],
        ])->delete();
        if ($interact === 'bagged') {
            UserProgress::where([
                ['post_id', $post->id],
                ['user_id', Auth::user()->id],
            ])->delete();

            UserNotification::where([
                ['post_id', $post->id],
                ['user_id', Auth::user()->id],
            ])->delete();
        }

        return $success;
    }

    public function handleAddInteract($post, $request)
    {
        $newInteract = userInteract::firstOrCreate([
            'post_id' => $post->id,
            'user_id' => Auth::user()->id,
            'interact' => $request->interact,
        ]);

        return $newInteract;
    }

    public function impactPostData($post, $impactType, $reqInteract)
    {
        if (!$reqInteract) {
            return false;
        }
        $interact = str_replace('un-', '', $reqInteract->interact);
        $postJsonData = file_get_contents(
            public_path('content/posts') . '/' . $post->pid . '.json'
        );
        $postJsonData = json_decode($postJsonData, true);

        if (
            $impactType === 'decrement' &&
            in_array(Auth::user()->id, $postJsonData[0]['interact'][$interact])
        ) {
            $dbSaved = $post->decrement('nums_' . $interact);
            $postJsonData[0]['nums_' . $interact] =
            ($postJsonData[0]['nums_' . $interact] > 1) ?
            $postJsonData[0]['nums_' . $interact]-- :
            0;
            $postJsonData[0]['interact'][$interact] = array_diff(
                $postJsonData[0]['interact'][$interact],
                array(Auth::user()->id)
            );
        }

        if (
            $impactType === 'increment' &&
            !in_array(Auth::user()->id, $postJsonData[0]['interact'][$interact])
        ) {
            $dbSaved = $post->increment('nums_' . $interact);
            $postJsonData[0]['nums_' . $interact] =
            ($postJsonData[0]['nums_' . $interact] !== null) ?
            $postJsonData[0]['nums_' . $interact]++ :
            1;
            array_push(
                $postJsonData[0]['interact'][$interact],
                Auth::user()->id
            );
        }

        return file_put_contents(
            public_path('content/posts') . '/' . $post->pid . '.json',
            json_encode($postJsonData)
        );
    }

    public function baggedPosts()
    {
        $postsBagged = userInteract::where('user_id', Auth::user()->id)->where('interact', 'bagged')->orderBy('id', 'desc')->select(['post_id'])->get()->toArray();

        $posts = Post::whereIn('id', $postsBagged)->select(['id', 'pid', 'type'])->orderBy('id', 'desc')->simplePaginate(10);

        return response()->json($posts, $this->successStatus);
    }

    public function SaveLearnt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $post = Post::where('pid', $request->post_id)->firstOrFail();
        $this->AddLearningProcess($post);
        $this->exportLearntJson($post);

        return response()->json(['success' => 1], $this->successStatus);
    }

    public function exportLearntJson($post)
    {
        $learntSaved = UserProgress::where([
            ['user_id', Auth::user()->id],
            ['post_id', $post->id],
        ])->orderBy('learnt_at')->get();

        // Carbon::parse($dateString)
        $dataExport = [];
        $firstDay = null;
        $supposedLearnt = $this->fibonacciDates();
        $index = 0;
        foreach ($learntSaved as $userLearnt) {
            if (!$firstDay) {
                $firstDay = $userLearnt->learnt_at;
            }
            $supposedDay = Carbon::parse($firstDay)->addDays($supposedLearnt[$index] - 1)->toDateString();
            $currentDay = Carbon::parse($userLearnt->learnt_at)->toDateString();
            // dump($supposedDay, $currentDay);
            if ($currentDay === $supposedDay) {
                array_push($dataExport, $userLearnt->learnt_at);
                $index++;
            }
        }

        if (!file_exists(public_path('content/progress'))) {
            mkdir(public_path('content/progress'), 0777);
        }

        return file_put_contents(
            public_path('content/progress') . '/' . Auth::user()->id . '_' . $post->pid . '.json',
            json_encode($dataExport)
        );
    }

    public function AddLearningProcess($post)
    {
        $learntSaved = UserProgress::firstOrCreate([
            'post_id' => $post->id,
            'user_id' => Auth::user()->id,
            'learnt_at' => Carbon::now()->toDateString(),
        ]);

        return $learntSaved;
    }

    public function calculateLearningDay($post)
    {
        $dateArray = [];
        $fibonacciDates = $this->fibonacciDates();
        foreach ($fibonacciDates as $num) {
            $dayNow = new Carbon();
            array_push($dateArray, $dayNow->addDays($num - 1)->toDateString());
        }
        $success = $this->saveSupposedNotification($post, $dateArray);
        return response()->json($success);
    }
    public function fibonacciDates($defaultLength = 8, $returnDates = [1], $index = 0)
    {
        if ($index >= $defaultLength - 1) {
            return $returnDates;
        }
        $nextDate = $index === 0 ?
        $returnDates[$index] + $returnDates[$index] :
        $returnDates[$index] + $returnDates[$index - 1];
        array_push($returnDates, $nextDate);

        $index++;
        return $this->fibonacciDates($defaultLength, $returnDates, $index);
    }

    public function saveSupposedNotification($post, $dateArray)
    {
        if (count($dateArray) <= 0) {
            return ["success" => "empty"];
        }
        foreach ($dateArray as $date) {
            $dataSaveArray = [
                'post_id' => $post->id,
                'user_id' => Auth::user()->id,
                'time_notification' => $date,
            ];
            UserNotification::firstOrCreate($dataSaveArray);
        }

        return ["success" => 1];
    }

    public function seenNotification($slug)
    {
        $post = Post::where('pid', $slug)->firstOrFail();
        $dayNow = Carbon::now()->toDateString();

        $userNotification = UserNotification::where([
            ['post_id', $post->id],
            ['user_id', Auth::user()->id],
            ['time_notification', $dayNow],
        ])->firstOrFail();

        $userNotification->seen = 1;
        $userNotification->save();

        return response()->json(['success' => 1], $this->successStatus);
    }
}
