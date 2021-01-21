<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class WebpushController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endpoint' => 'required',
            'keys_auth' => 'required',
            'keys_p256dh' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $endpoint = $request->endpoint;
        $token = $request->keys_auth;
        $key = $request->keys_p256dh;
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }
}
