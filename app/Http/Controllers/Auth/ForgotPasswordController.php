<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Show form to send password reset link
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Custom sendResetLinkEmail to create and send token
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        $token = Str::random(60);
        $user->update(['reset_token' => $token]);

        $this->sendEmail($user, $token);

        return back()->with('status', 'We have emailed your password reset link!');
    }

    // Send password reset link via email
    protected function sendEmail($user, $token)
    {
        $reset_link = route('password.reset', ['token' => $token]);

        $user->sendPasswordResetNotification($reset_link);
    }

    // Show reset password form
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $user = User::where('email', $request->email)->where('reset_token', $request->token)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid email or token.']);
        }

        $user->update([
            'password' => bcrypt($request->password),
            'reset_token' => null
        ]);

        event(new PasswordReset($user));

        return redirect('/login')->with('status', 'Password has been reset successfully!');
    }
}

