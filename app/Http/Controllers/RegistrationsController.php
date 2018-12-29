<?php

namespace App\Http\Controllers;

use App\EscapeRoom;
use App\GifStop;
use App\LoveLetterGenerator;
use App\MutualAccomplishment;
use App\PaymentCategory;
use App\PaymentDetail;
use Illuminate\Http\Request;
use App\User;

class RegistrationsController extends Controller {

    public function show()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $this->validate(request(), [
            'email'    => 'required|max:255|email|unique:users',
            'password' => 'required|min:6|max:255|confirmed'
        ]);

        $user = User::forceCreate([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remainingPoints' => 500,
        ]);

        auth()->login($user);

        PaymentDetail::record(auth()->id(), 'deposit', 'gift', 500, '');

        return redirect()->home();
    }


}
