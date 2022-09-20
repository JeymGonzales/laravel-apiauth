<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class AuthController extends Controller
{
    //
    public $loginAfterRegistration = true;

    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");
        $token = null;
        
        if(!$token = JWTAuth::attempt($credentials))
        { 
            return response()->json([
                "status" => false,
                "message" => "Unauthorized"
            ]);
        }

        return response()->json([
            "status" => true,
            "token" => $token
        ]);
    }

    public function register(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:10'
            // add confirm password
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();


        if($this->loginAfterRegistration)
        {
            return $this->login($request);
        }

        return response()->json([
            "status" => 200,
            "user" => $user
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            "token" => "required"
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                "status" => 200,
                "message" => "User Logged Out"
            ]);
        } catch(JWTException $exception) {
            return response()->json([
                "status" => 500,
                "message" => "Something went wrong!!!"
            ]);
        }
    }
}
