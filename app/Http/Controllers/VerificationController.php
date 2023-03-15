<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\EmailVerified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request): UserResource
    {
        $user = User::find($request->id);
        $request->fulfill();
        $user->notify(new EmailVerified());
        return new UserResource($user);
    }

    public function resendVerification(): UserResource|JsonResponse{
        $user=Auth::user();
        if($user->hasVerifiedEmail()){
            return response()->json(['message'=>'User already has verified email'], 422);
        }
        $user->sendEmailVerificationNotification();
        return new UserResource($user);
    }
}
