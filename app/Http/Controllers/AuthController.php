<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\Login;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // login
    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username_or_phone_number)
            ->orWhere('phone_number', $request->username_or_phone_number)
            ->first();

        if (!$user)
        {
            return response()->json('کاربر یافت نشد');
        }
        if (!Hash::check($request->password, $user->password))
        {
            return response()->json('رمز عبور صحیح نمی باشد');
        }
        $expiresAt = $request->remember_me ? now()->addWeek(1) : now()->addDay(1);
        $token = $user->createToken($request->username_or_phone_number, expiresAt: $expiresAt)->plainTextToken;
        return response()->json(['token' => $token]);
    }

    // logout
    public function logout()
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
    }

    // Me
    public function me()
    {
        $user = Auth::user();
        return response()->json($user);
    }
}
