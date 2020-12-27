<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\User;

class SocialAuthController extends Controller
{
    public function login(Request $request, $provider)
    {
        if ($provider == 'google') {
            $validator = Validator::make($request->all(), [
                'social_token' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            return $this->checkGoogle($request->social_token);
        }

        if ($provider == 'facebook') {
            $validator = Validator::make($request->all(), [
                'social_token' => 'required',
                'user_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            return $this->checkFacebook($request->user_id, $request->social_token);
        }
    }

    /**
     * @param String $social_token
     * @return void
     */
    public function checkGoogle($social_token)
    {
        try {
            $checkToken = file_get_contents("https://oauth2.googleapis.com/tokeninfo?id_token=$social_token");
            $responseGoogle = json_decode($checkToken, true);

            return $this->checkUserByEmail($responseGoogle);
        } catch (\Exception $e) {
            return $this->responseBadRequest(['message' => $e->getMessage()]);
        }
    }

    /**
     * @param String $social_token
     * @return void
     */
    public function checkFacebook($user_id, $social_token)
    {
        try {
            $checkToken = file_get_contents("https://graph.facebook.com/$user_id
            ?fields=name,email
            &access_token=$social_token");
            $responseFacebook = json_decode($checkToken, true);

            return $this->checkUserByEmail($responseFacebook);
        } catch (\Exception $e) {
            return $this->responseBadRequest(['message' => $e->getMessage()]);
        }
    }

    /**
     * @param $profile
     * @return void
     */
    public function checkUserByEmail($profile)
    {
        $user = User::where('email', $profile['email'])->first();
        if (!$user) {
            $user = User::create([
                'full_name' => $profile['name'],
                'email' => $profile['email'],
                'password' => bcrypt(str_random(8)),
            ]);
            $userInfo = $user->info()->create();
        }

        $user->forceFill([
            'email' => $user['email'],
            'email_verified_at' => Carbon::now(),
        ])->save();

        $success['token'] = $user->createToken(env('APP_NAME'))->accessToken;
        $success['user'] = $user;

        return response()->json(['success' => $success], 200);
    }
}
