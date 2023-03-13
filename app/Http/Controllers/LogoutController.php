<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshToken;

class LogoutController extends Controller
{
   public function __invoke(){
       /**
        * Check if the user is logged in
        * Log them out
        * Revoke the access token
        */

       Auth::check();
       $user=Auth::user();
       if($user){
           $user->tokens->each(function ($token){
               RefreshToken::where('access_token_id', '=', $token->id)->delete();
               $token->delete();
           });
       }
       return response()->json([
           'message'=> 'Successfully logged out'
       ]);

   }
}
