<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $this->CreateUploadFol();
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
