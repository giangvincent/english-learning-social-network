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
        return response()->json(['success' => $request->all()], $this->successStatus);
    }
}
