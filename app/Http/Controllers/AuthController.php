<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthenticationException;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Services\Auth\AuthenticationService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private AuthenticationService $authenticationService)
    {}

    public function login(UserLoginRequest $request): JsonResponse {
        try {
            $this->authenticationService->authenticate($request->only('email', 'password'));
            return response()->json([
                'token' => auth()->user()->createToken('create_token')->plainTextToken,
                'user' => $this->authenticationService->createResponse(auth()->user()->only(['id', 'name', 'email']))
            ]);
        } catch (AuthenticationException $error) {
            return response()->json(['error' => $error->getMessage()], $error->getCode());
        }
    }

    public function register(UserRegisterRequest $request): JsonResponse {
        $credentials = $request->only('name', 'email', 'password');
        $credentials['password'] = Hash::make($credentials['password']);
        try {
            $this->authenticationService->create($credentials);
            return response()->json(['msg' => 'User has been created'], Response::HTTP_CREATED);
        } catch (AuthenticationException $error) {
            return response()->json(['error' => $error->getMessage()], $error->getCode());
        }
    }
}
