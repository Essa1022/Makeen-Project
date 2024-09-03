<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->can('see.user'))
        {
        $users = User::paginate(10);
        return $this->responseService->success_response($users);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    public function show(Request $request, string $id)
    {
        if ($request->user()->can('see.user'))
        {
            $user = User::find($id);
            return UserResource::make($user);
        }
    }
    public function show_profile(Request $request)
    {
        $user = User::find(Auth::id());
        return UserResource::make($user);
    }

    public function store(CreateUserRequest $request)
    {
        if ($request->user()->can('create.user'))
        {
            $input = $request->except(['status']);
            $user = User::create($input);
            $user->assignRole($request->input('role'));
            return $this->responseService->success_response($user);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    public function update_profile(UpdateUserRequest $request)
    {
        $user = User::find(Auth::id());
        $input = $request->except(['password', 'status']);
        $user->update($input);
        return $this->responseService->success_response($user);
    }

    public function change_password(Request $request)
    {
        $request->validate(['password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/^[A-Za-z0-9\W]+$/']]);
        $user = User::find(Auth::id());
        $user->update(['password' => $request->password]);
        return $this->responseService->success_response($user);
    }

    public function change_status(Request $request, string $id)
    {
        if ($request->user()->can('update.user'))
        {
            $request->validate(['status' => 'required|in:active,inactive']);
            $user = User::find($id);
            $user->update(['status' => $request->status]);
            return $this->responseService->success_response($user);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

}
