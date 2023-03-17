<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\FirebaseLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Laravel\Firebase\Facades\Firebase;

/**
 * @group Auth
 */
class LoginController extends Controller
{
    /**
     * sign in using token exchange
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function tokenExchange(LoginRequest $request): JsonResponse
    {
        $auth = Firebase::auth();

        try {
            $verifiedIdToken = $auth->verifyIdToken($request->idToken);
        } catch (\InvalidArgumentException $e) {

            return response()->json([
                'message' => 'Unauthorized - Can\'t parse the token: ' . $e->getMessage()
            ], 401);

        } catch (FailedToVerifyToken $e) {
            return response()->json([
                'message' => 'Failed to verify: ' . $e->getMessage()
            ], 401);
        }

        $email = $verifiedIdToken->claims()->get('email');
        $user = User::where('email', '=', $email)->get();

        if ($user == null) {
            $user = User::create([
                'name' => $request->name,
                'email' => $email
            ]);
            $user->sendEmailVerificationNotification();
        }

        $tokenResult = $user->createToken('Personal Access Token');
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'expires_in' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => new UserResource($user)
        ]);

    }

    /**
     * Sign in using email and password
     * @param FirebaseLoginRequest $request
     * @return JsonResponse
     */
    public function signInWithEmailAndPassword(FirebaseLoginRequest $request)
    {
        $auth = Firebase::auth();
        $auth->signInWithEmailAndPassword($request->email, $request->password);

        $user = User::firstOrCreate(
            [
                'email' => $request->email
            ], [
            'name' => $request->name,
            'email' => $request->email
        ]);
        $user->sendEmailVerificationNotification();
        $tokenResult = $user->createToken('Personal Access Token');
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'expires_in' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => new UserResource($user)
        ]);
    }

}
