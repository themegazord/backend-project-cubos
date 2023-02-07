<?php

namespace App\Http\Controllers;

use App\Actions\Utils\ValidateCPF;
use App\Exceptions\CPFException;
use App\Exceptions\UserExceptions;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {

    }
    public function show(User $user): JsonResponse
    {
        return response()->json([$user->only(['id','name', 'email', 'cpf', 'phone'])]);
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        try {
            $request['password'] = Hash::make($request['password']);
            $this->userService->update($request->all(), $user);
            return response()->json(['msg' => 'Atualizado com sucesso']);
        } catch (CPFException|UserExceptions $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
