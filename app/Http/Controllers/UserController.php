<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\FormatResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request): Response
    {
        $data = $request->validated();
        $user = new User($data);
        $user->password = Hash::make($data["password"]);
        $user->save();
        return FormatResource::success(201, new UserResource($user));
    }

    public function login(UserLoginRequest $request): Response
    {
        $data = $request->validated();
        if(!Auth::attempt($data))
        {
            FormatResource::error(400, [
                "message" => ["Wrong username or password"]
            ]);
        }
        $token = $request->user()->createToken('token')->plainTextToken;
        $cookie = cookie('session', encrypt($token), 60 * 24);
        $res = Auth::user();
        $res->token = $token; 
        return FormatResource::success(200, $res)->withCookie($cookie);
    }

    public function logout()
    {
        $cookie = Cookie::forget('session');
        return FormatResource::success(200, [
            "message" => "Logout successful"
        ])->withCookie($cookie);
    }

    public function get()
    {
        return Auth::user();
    }
}
