<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // login
    public function login(Request $request)
    {
        $user = User::select('id', 'username', 'password')
            ->where('username', $request->username)->first();

        if (!$user)
        {
            return response()->json('کاربر یافت نشد');
        }
        if (!Hash::check($request->password, $user->password))
        {
            return response()->json('رمز عبور صحیح نمی باشد');
        }
        $token = $user->createToken($request->username, expiresAt: now()->addHours(2))->plainTextToken;
        return response()->json(['token' => $token]);
    }

    // logout
    public function logout()
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
    }
}
