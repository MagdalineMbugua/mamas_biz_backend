<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::orderby('created_at', 'desc')->paginate());
    }

    public function store(CreateUserRequest $request)
    {
        $user = new User($request->validated());
        $user->password = Hash::make($request->password);
        $user->save();

        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return new UserResource(tap($user)->update($request->validated()));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
