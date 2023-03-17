<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Laravel\Firebase\Facades\Firebase;

/**
 * @group Auth
 */
class PasswordResetController extends Controller
{
    /**
     * send password reset link
     * @param Request $request
     * @return JsonResponse
     */
    public function sendPasswordResetLink(Request $request): JsonResponse
    {
        $auth = Firebase::auth();
        $auth->sendPasswordResetLink($request->email);
        return response()->json(['message' => 'An email has been sent with the password reset link']);
    }

    /**
     * change password
     * @param PasswordResetRequest $request
     * @return JsonResponse
     * @throws AuthException
     * @throws FirebaseException
     */
    public function passwordReset(PasswordResetRequest $request): JsonResponse
    {
        $auth = Firebase::auth();
        $auth->confirmPasswordReset($request->oob_code, $request->new_password);
        $uid = $auth->getUserByEmail($request->email)->uid;
        $auth->changeUserPassword($uid, $request->new_password);
        return response()->json(['message' => 'Password reset was successful']);
    }
}
