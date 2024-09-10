<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index():View
    {  
        return view('auth.login');
    }
    public function login(LoginRequest $request):JsonResponse
    {
        $usr = User::where(['email' => $request->email])->whereIn('user_type',['admin'])->first();
        if (!$usr) {
            return response()->json([
                'message' => 'User not found!',
            ], 401);
        }
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Credentials do not match!',
                'success' => false,
            ], 401);
        }
        return response()->json(['message' => 'Login Successfull', 'success' => true]);
    }
    public function logout(){
        auth()->logout();
        return redirect()->route('login.view');
    }
}
