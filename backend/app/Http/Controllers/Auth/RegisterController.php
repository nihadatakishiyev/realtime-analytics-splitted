<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register( Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['message' => implode("<br/>",$validator->messages()->all())], 422);
        }

        $request->merge(['password' => bcrypt($request->password)]);

        $user = User::create($request->all());

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }
}
