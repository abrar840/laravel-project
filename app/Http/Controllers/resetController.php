<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
class resetController extends Controller
{
    public function updatepassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Send password reset link using Laravel's Password broker
        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response === Password::RESET_LINK_SENT) {
            return redirect()->back()->with('status', __($response));
        } else {
            return redirect()->back()->withErrors(['email' => __($response)]);
        }
    }





    public function showResetForm($token)
    {
        return view('resetpassword', ['token' => $token, 'email' => request('email')]);
    }




    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $response === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($response))
                    : back()->withErrors(['email' => [__($response)]]);
    }







}
