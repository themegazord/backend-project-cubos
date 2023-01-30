<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthenticationException;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\Auth\AuthenticationService;

class AuthController extends Controller
{
    public function __construct(private AuthenticationService $authenticationService)
    {}

    public function login(UserLoginRequest $request) {
        try {
            $this->authenticationService->authenticate($request->only('email', 'password'));
        } catch (AuthenticationException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
        return response()->json([
            'token' => auth()->user()->createToken('create_token')->plainTextToken,
            'user' => $this->authenticationService->createResponse(auth()->user()->only(['id', 'name', 'email']))
        ]);
    }

    public function register(UserRegisterRequest $request) {
        $credentials = $request->only('name', 'email', 'password');
        $credentials['password'] = Hash::make($credentials['password']);

        $this->authenticationService->create($credentials);

        return response()->json(['msg' => 'User has been created'], 201);
    }
}
