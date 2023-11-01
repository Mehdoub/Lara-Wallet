<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Interfaces\Controllers\Api\V1\AuthControllerInterface;
use App\Exceptions\UnauthorizedException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller implements AuthControllerInterface
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register', 'refresh']]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if(!$token) throw new UnauthorizedException(__('auth.errors.failed'));

        return Response::message(__('auth.messages.logged_in'))->data(['access_token' => $token])->send();
    }

    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return Response::message(__('auth.messages.registered'))->status(201)->send();
    }

    public function refresh()
    {
        return Response::message(__('auth.messages.tkn_refreshed'))->data(['access_token' => auth()->refresh()])->send();
    }

    public function getme()
    {
        return Response::message(__('auth.messages.user_found'))->data(auth()->user())->send();
    }

    public function logout()
    {
        auth()->logout();
        return Response::message(__('auth.messages.logged_out'))->send();
    }
}
