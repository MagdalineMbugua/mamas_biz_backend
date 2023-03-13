<?php

namespace App\Http\Controllers;

use App\Http\Requests\FirebaseLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Laravel\Firebase\Facades\Firebase;

class LoginController extends Controller
{
    public function tokenExchange(LoginRequest $request)
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
        $user = User::firstOrCreate(
            [
                'email' => $email
            ],[
            'name' => $request->name,
            'email' => $email
        ]);
        $tokenResult = $user->createToken('Personal Access Token');
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'expires_in' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => new UserResource($user)
        ]);

    }

    public function signInWithEmailAndPassword(FirebaseLoginRequest $request)
    {
        $auth = Firebase::auth();
        $auth->signInWithEmailAndPassword($request->email, $request->password);
        $user=User::firstOrCreate(
            [
                'email'=> $request->email
            ],[
            'name'=>$request->name,
            'email'=> $request->email
        ]);
      $tokenResult=  $user->createToken('Personal Access Token');
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'expires_in' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => new UserResource($user)
        ]);
    }
}
