<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Hr;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validate data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'role' => 'required|in:student,teacher',
            'email' => 'required|email|min:10|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:30|confirmed'

        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Data validation error.', 'errors' => $validator->errors()], 422);
        }

        // create user
        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => "New user created successfully"], 201);
    }

    public function login(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|min:10|max:255',
            'password' => 'required|string|min:8|max:30'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Data validation error'], 422);
        }

        try {
            $credentials = $request->only(['email', 'password']);
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            return response()->json(['message' => 'User logged successfully', 'token' => $token, 'user' => $request->email], 200);
        } catch (JWTException $error) {
            return response()->json(['message' => 'Could not create token', 'error' => $error], 500);
        }
    }


    public function getUser()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Log out successfully'], 200);
        } catch (JWTException $error) {
            return response()->json(["message" => 'Failed to logout, token invalid'], 500);
        }
    }
}
