<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


        //fetch user by order of creation date
        public function index(){
            $users = User::orderby('created_at', 'desc') -> paginate(20);
            return $users;
        
        }
        
        // add user
        public function store(User $user){
          return User::create($user->validated());
        
        }
        
        //display a user
        public function show (User $user_id){
            return User::findorfail($user_id);
        }
        
        //updating a user
        public function update (User $user_id, User $user){
            return User::findorfail($user_id) ->update($user ->validated());
        }
        
        //deleting a user
        public function delete(User $user_id){
            return User::findorfail($user_id)->delete;
        }
  
}
