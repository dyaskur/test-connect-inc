<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
}
