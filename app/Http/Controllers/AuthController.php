<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::query()->create($request->data());
        } catch (Exception $e) {
            return response()->json([
                                        'success' => false,
                                        'message' => $e->getMessage(),
                                        'data'    => null,
                                    ], 401);
        }

        return response()->json([
                                    'success' => true,
                                    'data'    => $user,
                                    'message' => "Register is successful",
                                ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                                            'success' => false,
                                            'message' => "Invalid password or email",
                                            'data'    => null,
                                        ], 422);
            }

            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (Exception $e) {
            return response()->json([
                                        'success' => false,
                                        'message' => $e->getMessage(),
                                        'data'    => null,
                                    ], 500);
        }

        return response()->json([
                                    'success' => true,
                                    'data'    => [
                                        'token' => $token,
                                        'user'  => $user,
                                    ],
                                    'message' => "Login is successful",
                                ]);
    }

    // method for user logout and delete token
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
                                    'success' => true,
                                    'message' => "You have successfully logged out and the token was successfully deleted",
                                ]);
    }
}
