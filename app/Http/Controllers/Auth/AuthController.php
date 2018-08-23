<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $validation = self::required($request);
        if ($validation->fails()) {
            return response()->json(['success'=> false, 'error'=> $validation->messages()]);
        } else {
            $user = new User;
            $user = self::fields($user, $request);
            $token = auth()->login($user);
            return $this->respondWithToken($token);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout(Request $request) {
        $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }

    /**
     * API Recover Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $error_message = "Your email address was not found.";
            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
        }
        try {
            Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject('Your Password Reset Link');
            });
        } catch (\Exception $e) {
            //Return with error
            $error_message = $e->getMessage();
            return response()->json(['success' => false, 'error' => $error_message], 401);
        }
        return response()->json([
            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
        ]);
    }

    //Filling Model
    public function fields($object, Request $request) {
        $data                 = $request->all();
        $object->name         = $data['name'];
        $object->email        = $data['email'];
        $object->password     = bcrypt($data['password']);
        $object->last_name    = $data['last_name'];
        $object->nickname     = $data['nickname'];
        $object->avatar       = $data['avatar'];
        $object->save();
        return $object;
    }
    //Validate Form
    public function required(Request $request) {
        $rules = array(
            'name'                 => 'required|string|min:3|max:255',
            'email'                => 'required|email|unique:users,email',
            'password'             => "required|string|min:3|max:32",
            'last_name'            => "required|string|min:3|max:255",
            'nickname'             => "required|string|min:3|max:255|unique:users,nickname",
            'avatar'               => "required|string|min:3|max:255",
        );
        return  $validator = Validator::make($request->all(), $rules);
    }

}
