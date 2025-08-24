<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
  public function login(string $email, string $password): array
  {
    $user = User::where('email', $email)->first();
    if (!$user || !Hash::check($password, $user->password))
      throw new Exception("The provided credentials are incorrect.");

    return [
      "message" => "Login Successful",
      "token" => $user->createToken("api_token")->plainTextToken,
    ];
  }

  public function register(string $name, string $email, string $password): User
  {
    $user = User::query()->create([
      'name' => $name,
      'email' => $email,
      'password' => $password,
    ]);

    if (!$user)
      throw new Exception("Error creating user");

    return $user;
  }
}
