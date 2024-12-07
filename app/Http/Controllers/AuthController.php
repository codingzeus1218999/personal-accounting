<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'data' => null,
                    'message' => $validator->errors(), // Detailed validation error messages
                ], 422);
            }

            // Fetch the user by email
            $user = User::where('email', $request->email)->first();

            // Check if the user exists and the password matches
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'data' => null,
                    'message' => 'Invalid credentials',
                ], 401);
            }

            // Generate an access token
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'status' => true,
                'data' => ['token' => $token],
                'message' => 'Login successful',
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Login Error: ' . $e->getMessage());

            // Return a generic error response
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'An error occurred during login. Please try again later.',
            ], 500);
        }
    }
}
