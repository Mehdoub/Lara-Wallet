<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\UnauthorizedException;
use App\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if(!$token) throw new UnauthorizedException(__('auth.failed'));

        return Response::message(__('auth.logged_in'))->data(['access_token' => $token])->send();
    }

    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return Response::message(__('auth.registered'))->send();
    }

    public function refresh()
    {
        return Response::message(__(''))->data(['access_token' => auth()->refresh()])->send();
    }

    public function getme()
    {
        return Response::message(__(''))->data(auth()->user())->send();
    }

    public function logout()
    {
        auth()->logout();
        return Response::message(__('auth.logged_out'))->send();
    }
}
