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
        $users = User::all();
        return response()->json($users);
    }

    // Show specific User
    public function show(Request $request, string $id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    // Store a new User
    public function store(CreateUserRequest $request)
    {
        $user = User::create($request->merge([
            "password" => Hash::make($request->password)])
            ->toArray());
        return response()->json($user);
    }

    // Update User
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id)->update($request->merge([
            "password" => Hash::make($request->password)])
            ->toArray());
        return response()->json($user);
    }

    // Destroy User
    public function destroy(Request $request)
    {
        $user_ids = $request->input('user_ids');
        User::destroy($user_ids);
    }
}
