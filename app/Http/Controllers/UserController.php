<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(UserStoreRequest $request) {
        if ($request->validated()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['message' => 'Account has been created successfully.'], 201);
        } else {
            return response()->json($request->all(), 422);
        }
    }

    public function auth(AuthUserRequest $request) {
        $user = User::whereEmail($request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        } else {
            return response()->json([
                'message' => 'Logged in successfully',
                'user' => $user,
                'token' => $user->createToken('authToken')->plainTextToken
            ], 200);
        }
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
