<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Users index
    public function index(Request $request)
    {
        if($request->user()->can('see.user'))
        {
            $users = User::all();
            return $this->responseService->success_response($users);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Show specific User
    public function show(Request $request, string $id)
    {
        if($request->user()->can('see.user') || $request->user()->id == $id)
        {
            $user = User::find($id);
            return $this->responseService->success_response($user);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Store a new User
    public function store(CreateUserRequest $request)
    {
        if($request->user()->can('create.user'))
        {
            $user = User::create($request->merge([
                "password" => Hash::make($request->password)])
                ->toArray());
            return $this->responseService->success_response($user);
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Update User
    public function update(UpdateUserRequest $request, string $id)
    {
        if($request->user()->can('update.user') || $request->user()->id == $id)
        {
            $user = User::find($id)->update($request->merge([
                "password" => Hash::make($request->password)])
                ->toArray());
            return $this->responseService->success_response($user);
            }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }

    // Destroy User
    public function destroy(Request $request)
    {
        if($request->user()->can('destroy.user'))
        {
            $user_ids = $request->input('user_ids');
            User::destroy($user_ids);
            return $this->responseService->delete_response();
        }
        else
        {
            return $this->responseService->unauthorized_response();
        }
    }
}
