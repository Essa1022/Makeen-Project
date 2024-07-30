<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function show(Request $request)
    {
        if($request->user()->can('see.user'))
        {
            $user = User::find(Auth::id());
            return $this->responseService->success_response($user);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

public function update(UpdateUserRequest $request)
{
    if($request->user()->can('update.user'))
    {
        $user = User::find(Auth::id());
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user->update($input);
        return $this->responseService->success_response($user);
    }
    else
    {
        return $this->responseService->unauthorized_response();
    }
    // $user = User::find(Auth::id());
    // $user->update($request->toArray());
    // return response()->json($user);
}
}
