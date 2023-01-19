<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use App\Repositories\Auth\AuthRepository;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = new User;
        $pat = new PersonalAccessToken();

        $credentials = $request->validate($user->rulesLogin(), $user->feedbackLogin());

        if(!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $token = auth()->user()->createToken('create_token');
        $tokenUser = $pat->findToken($token->plainTextToken)->tokenable()->get()->toArray();
        $authRepository = new AuthRepository();
        $response['token'] = $token->plainTextToken;
        $response['id'] = $authRepository::getIdUser($tokenUser);
        $response['name'] = $authRepository::getUserName($tokenUser);
        $response['aka'] = $authRepository::generateAkaNameUser($tokenUser);
        return response()->json($response);
    }

    public function register(Request $request) {
        $user = new User;
        $credentials = $request->validate($user->rulesRegister(), $user->feedbackRegister());
        $credentials['password'] = Hash::make($credentials['password']);
        return response()->json(['msg' => 'User has been created'], 201);
    }
}
