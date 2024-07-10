<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\UserAccessToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('passportToken')->accessToken;

            $UserAccessToken = UserAccessToken::create([
                'user_id'=>$user->id,
                'access_token'=>$token
            ]);

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Invalid Credentials.'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

         if ($user) {
            $user->token()->revoke();

            $user->user_access_token->delete();
            return response()->json(['message' => 'Successfully logged out'],200);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    
    public function getUser(Request $request)
    {
        return response()->json($request->user());
    }
}
