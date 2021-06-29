<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


     //fetch user by order of creation date
    public function index()
    {
        $users = User::orderby('created_at', 'desc')->paginate(20);
        return $users;
    }
        
    // add user
    public function store(CreateUserRequest $request)
    {
        $user = new User($request->validated());
        $user->password = Hash::make($request->password);
        $user->save();

        return new UserResource($user);
    }
        
    //display a user
    public function show(User $user)
    {
        return new UserResource($user);
    }
        
    //updating a user
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }
        
    //deleting a user
    public function destroy(User $user)
    {
        return $user->delete();
    }
}
