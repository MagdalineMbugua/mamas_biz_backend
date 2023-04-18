<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFCMRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @group fcm
 */
class RegisterFCMController extends Controller
{
    /**
     * Register fcm tokens
     * @param CreateFCMRequest $request
     * @return JsonResponse
     */
    public function __invoke(CreateFCMRequest $request): JsonResponse
    {
        try {
            Auth::user()->update($request->validated());
            return response()->json([
                'data' => [
                    'message' => 'Updated successfully',
                ],
            ]);
        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'data' => [
                    'message' => 'Failed',
                ],
            ], 500);
        }
    }
}
