<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse(
                ['user' => $user, 'token' => $token],
                'User registered successfully',
                201
            );
        } catch (ValidationException $e) {
            return $this->errorResponse(
                'Validation failed',
                422,
                $e->errors()
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Registration failed',
                500
            );
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);

            if (!Auth::attempt($validated)) {
                return $this->errorResponse('Invalid credentials', 401);
            }

            $user = User::where('email', $validated['email'])->first();

            // Delete any existing tokens for this user
            $user->tokens()->delete();

            // Create new token
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse(
                ['user' => $user, 'token' => $token],
                'Logged in successfully'
            );

        } catch (ValidationException $e) {
            return $this->errorResponse(
                'Validation failed',
                422,
                $e->errors()
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Login failed',
                500
            );
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->successResponse(
                null,
                'Logged out successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Logout failed',
                500
            );
        }
    }
}
