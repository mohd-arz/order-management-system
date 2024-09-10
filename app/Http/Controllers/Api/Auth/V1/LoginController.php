<?php

namespace App\Http\Controllers\Api\Auth\V1;

use App\Actions\Api\Auth\ForgotPasswordAction;
use App\Actions\Api\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function register(RegisterRequest $request,RegisterAction $action):JsonResponse{
        $response = $action->execute(collect($request->validated()));
        if ($response) {
            
            /** @var User $authUser */
            $authUser = auth()->user();

            return response()->json([
                'message' => 'User Registered successfully',
                'data' => [
                    'name' => $authUser->name,
                    'email' => $authUser->email,
                    'userId' => $authUser->id,
                    'token' => $authUser->createToken('order-management')->plainTextToken,
                ],
            ]);
        }else{
            return response()->json([
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function login(LoginRequest $request):JsonResponse{
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Credentials do not match!',
            ], 401);
        }
        
        /** @var User $authUser */
        $authUser = auth()->user();

        return response()->json([
            'message' => 'Logged in successfully',
            'data' => [
                'name' => $authUser->name,
                'email' => $authUser->email,
                'userId' => $authUser->id,
                'token' => $authUser->createToken('order-management')->plainTextToken,
            ],
        ]);
    }
    public function logout():JsonResponse{
        /** @var User $authUser */
        $authUser = auth()->user();
        $authUser->tokens()->delete();
        return response()->json([
            "message" => "logged out"
        ]);
    }
    public function forgot_password(ForgotPasswordRequest $request,ForgotPasswordAction $action):JsonResponse{
        $response = $action->execute(collect($request->validated()));
        if ($response['status']) {
            return response()->json([
                'message' => $response['message'],
            ]);
        }else{
            return response()->json([
                'message' => $response['message'],
            ], $response['code']);
        }
    }
}
