<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PasswordResetLinkController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        $token = getUid();

        // Remove the existing token for the email, if any
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Insert the new token
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
        ]);

        $resetLink = config('app.frontend_url') . '/reset-password?token=' . $token . '&email=' . urlencode($email);

        // Send email
        Mail::to($email)->send(new PasswordResetMail($resetLink));

        return response()->json(['message' => 'Password Reset Email Sent Successfully.'], 200);
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $passwordReset = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();

            if ($passwordReset) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);

                DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->delete();

                return response()->json(['message' => 'Password Reset Successfully'], 200);
            } else {
                return response()->json(['error' => 'Invalid Token'], 400);
            }
        } else {
            return response()->json(['error' => 'User not found'], 400);
        }
    }

    // public function sendVerificationCode(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|string|email|max:255|exists:users,email'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 400);
    //     }

    //     $response = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     if ($response === Password::RESET_LINK_SENT) {
    //         return response()->json(['message' => 'Password Reset Email Sent Successfully.'], 200);
    //     } else {
    //         return response()->json(['error' => __($response)], 400);
    //     }
    // }

    // public function verification(Request $request)
    // {
    //     $email = $request->email;
    //     $email_verification_code = $request->email_verification_code;

    //     $user = User::where('email',$email)->first();

    //     if ($user && $user->email_verification_code === $email_verification_code) {
    //         return response()->json(['message' => 'Verification successful'], 200);
    //     }

    //     return response()->json(['message' => 'Invalid verification code'], 401);
    // }

    // public function resetPassword(Request $request)
    // {    
    //     $user = User::where('email', $request->email)->first();

    //     if ($user) {
    //         $passwordReset = DB::table(env('AUTH_PASSWORD_RESET_TOKEN_TABLE'))
    //         ->where('email', $request->email)
    //         ->where('token', $request->token)
    //         ->first();

    //         if ($passwordReset) {
    //             $user->update([
    //                 'password' => Hash::make($request->password),
    //             ]);

    //             DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    //             return response()->json(['message' => 'Password Reset Successfully'], 200);
    //         } else {
    //             return response()->json(['error' => 'Invalid Token'], 400);
    //         }
    //     } else {
    //         return response()->json(['error' => 'User not found'], 400);
    //     }
    // }
}
