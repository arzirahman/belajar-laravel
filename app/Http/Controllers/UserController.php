<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\FormatResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Utils\Response;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();
        $user = new User($data);
        $user->password = Hash::make($data["password"]);
        $user->save();
        return FormatResource::success(200, new UserResource($user));
    }
}
