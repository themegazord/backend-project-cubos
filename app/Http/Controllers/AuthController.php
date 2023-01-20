<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Auth\AuthRepository;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = new User;

        $credentials = $request->validate($user->rulesLogin(), $user->feedbackLogin());

        if(!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $token = auth()->user()->createToken('create_token');
        return response()->json(AuthRepository::createResponseToRegister($token->plainTextToken));
    }

    public function register(Request $request) {
        $user = new User;
        $credentials = $request->validate($user->rulesRegister(), $user->feedbackRegister());
        $credentials['password'] = Hash::make($credentials['password']);
        $user->create($credentials);
        return response()->json(['msg' => 'User has been created'], 201);
    }
}
