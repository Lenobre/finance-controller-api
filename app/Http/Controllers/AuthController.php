<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request, AuthService $service)
    {
        try {
            $payload = $request->validated();

            $result = $service->login($payload['email'], $payload['password']);
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function register(RegisterUserRequest $request, AuthService $service)
    {
        try {
            $payload = $request->validated();

            $service->register($payload['name'], $payload['email'], $payload['password']);
            return response()->json(["message" => "User created successfully"], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }
}
