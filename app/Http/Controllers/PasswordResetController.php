<?php

namespace App\Http\Controllers;

use App\Jobs\SendPasswordResetSMS;
use App\Models\PasswordReset;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function request_reset(Request $request)
    {
        $request->validate(['phone_number' => 'required|digits:10']);

        $user = User::where('phone_number', $request->phone_number)->first();
        if (!$user)
        {
            return response()->json(['error' => 'کاربر یافت نشد'], 404);
        }

        $PasswordReset = PasswordReset::where('user_id', $user->id)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        if (!$PasswordReset)
        {
            PasswordReset::where('user_id', $user->id)->delete();

            $code = rand(10000, 99999);
            $expiresAt = Carbon::now()->addMinutes(5);

            PasswordReset::create([
                'user_id' => $user->id,
                'code' => $code,
                'expires_at' => $expiresAt,
            ]);

            SendPasswordResetSMS::dispatch($user, $code);

            session(['user_id' => $user->id]);
            return response()->json(['message' => 'کد ارسال شد']);
        }
        else
        {
            return response()->json(['error' => 'درخواست غیر مجاز']);
        }
    }

    public function verify_code(Request $request)
    {
        $request->validate(['code' => 'required|digits:5']);

        $user_id = session('user_id');
        if (!$user_id)
        {
            return response()->json(['error' => 'دوباره تلاش کنید'], 400);
        }

        $passwordReset = PasswordReset::where('user_id', $user_id)
            ->where('code', $request->code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$passwordReset)
        {
            return response()->json(['error' => 'کد نادرست یا منقضی شده'], 400);
        }

        session(['verified_code' => $request->code]);
        return response()->json(['message' => 'کد تایید شد']);
    }

    public function reset_password(Request $request)
    {
        $request->validate(['password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/^[A-Za-z0-9\W]+$/'],
                    'repeat_password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/^[A-Za-z0-9\W]+$/']]);

        $user_id = session('user_id');
        $verified_code = session('verified_code');

        if (!$user_id || !$verified_code)
        {
            return response()->json(['error' => 'دوباره تلاش کنید'], 400);
        }
        if ($request->password != $request->repeat_password)
        {
            return response()->json(['error' => 'تکرار رمز صحیح نیست']);
        }

        $passwordReset = PasswordReset::where('user_id', $user_id)
            ->where('code', $verified_code)
            ->first();

        $user = User::find($user_id);
        $user->password = $request->password;
        $user->save();

        $passwordReset->delete();
        $request->session()->forget(['user_id', 'verified_code']);
        $token = $user->createToken($user->username, expiresAt: Carbon::now()->addDay(1))->plainTextToken;

        return response()->json([
            'message' => 'رمز عبور با موفقیت تغییر کرد',
            'token' => $token
        ]);
    }
}
