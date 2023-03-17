<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshToken;

/**
 * @group Auth
 */
class LogoutController extends Controller
{
    /**
     * log out
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        Auth::check();
        $user = Auth::user();
        $user?->tokens->each(function ($token) {
            RefreshToken::where('access_token_id', '=', $token->id)->delete();
            $token->delete();
        });
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
