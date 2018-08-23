<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /*
    |-------------------------------------------------------------------------------
    | Updates a User's Profile
    |-------------------------------------------------------------------------------
    | URL:            /api/user
    | Method:         PUT
    | Description:    Updates the authenticated user's profile
    */
    public function putUpdateUser(Request $request){
        $user = Auth::user();
        $validation = self::required($request);
        if ($validation->fails()) {
            return response()->json(['success'=> false, 'error'=> $validation->messages()]);
        } else {
            $user = self::fields($user, $request);
            return response()->json( ['success' => true], 201);
        }
    }

    //Filling Model
    public function fields($object, Request $request) {
        $data                 = $request->all();
        $object->name         = $data['name'];
        $object->last_name    = $data['last_name'];
        $object->save();
        return $object;
    }
    //Validate Form
    public function required(Request $request) {
        $rules = array(
            'name'                 => 'required|string|min:3|max:255',
            'last_name'            => "required|string|min:3|max:255",
        );
        return  $validator = Validator::make($request->all(), $rules);
    }
}
