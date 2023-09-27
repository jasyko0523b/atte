<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class EmailVerificationController extends Controller
{
    public function index(){
        return view('auth.verify-email');
    }

    public function verification(EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    }

    public function notification(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
