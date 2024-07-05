<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;

class PasswordResetLinkController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $email = $request->email;
        $six_digit_random_number = random_int(100000, 999999);

        $user = User::where('email',$email)->update([
            'email_verification_code' => $six_digit_random_number
        ]);

        return response()->json(['email',$email],200);
    }

    public function verification(Request $request)
    {
        $email = $request->email;
        $email_verification_code = $request->email_verification_code;

        $user = User::where('email',$email)->first();

        if ($user && $user->email_verification_code === $email_verification_code) {
            return response()->json(['message' => 'Verification successful'], 200);
        }

        return response()->json(['message' => 'Invalid verification code'], 401);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email',$email)->first();

        if($user){
            $user->update([
                'password' => bcrypt($request->password),
                'email_verification_code' => 473737,
            ]);

            Log::info($user);

            return response()->json(['message'=> 'Password Reset Successfully'],200);
        }

   }
    // /**
    //  * Display the password reset link request view.
    //  */
    // public function create(): Response
    // {
    //     return Inertia::render('Auth/ForgotPassword', [
    //         'status' => session('status'),
    //     ]);
    // }

    // /**
    //  * Handle an incoming password reset link request.
    //  *
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     if ($status == Password::RESET_LINK_SENT) {
    //         return back()->with('status', __($status));
    //     }

    //     throw ValidationException::withMessages([
    //         'email' => [trans($status)],
    //     ]);
    // }
}
