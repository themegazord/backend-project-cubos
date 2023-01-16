<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);

        if(!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $token = auth()->user()->createToken('create_token');

        return response()->json([
            'token' => $token->plainTextToken
        ]);
    }

    public function register(Request $request) {
        $user = new User;
        $credentials = $request->validate($user->rules(), $user->feedback());
        $credentials['password'] = Hash::make($credentials['password']);
        return response()->json($user->create($credentials), 201);
    }
}
