<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\EmailVerified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth
 */
class VerificationController extends Controller
{
    /**
     * Verify email
     * @param EmailVerificationRequest $request
     * @return UserResource
     */
    public function verify(EmailVerificationRequest $request): UserResource
    {
        $user = User::find($request->id);
        $request->fulfill();
        $user->notify(new EmailVerified());
        return new UserResource($user);
    }

    /**
     * Resend verification
     * @return UserResource|JsonResponse
     */
    public function resendVerification(): UserResource|JsonResponse{
        $user=Auth::user();
        if($user->hasVerifiedEmail()){
            return response()->json(['message'=>'User already has verified email'], 422);
        }
        $user->sendEmailVerificationNotification();
        return new UserResource($user);
    }
}
