<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

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
        return new UserResource(User::create($request->validated()));
    }
        
    //display a user
    public function show(User $user)
    {
        return new UserResource($user);
    }
        
    //updating a user
    public function update(UpdateUserRequest $request, User $user)
    {
        return new UserResource(tap($request)-> update($request ->validated())) ;
    }
        
    //deleting a user
    public function destroy (User $user)
    {
        return $user->delete;
    }
}
