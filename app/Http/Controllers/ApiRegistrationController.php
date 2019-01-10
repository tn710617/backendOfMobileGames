<?php

namespace App\Http\Controllers;

use App\EscapeRoom;
use App\GifStop;
use App\Helpers;
use App\LoveLetterGenerator;
use App\MutualAccomplishment;
use App\PaymentDetail;
use App\User;
use Illuminate\Http\Request;

class ApiRegistrationController extends Controller
{
    //
    public function register (Request $request)
    {
        $toBeValidated = [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|max:255'
        ];
        if ($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage, '400');
        }

        User::forceCreate([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user_id = User::where('email', $request->email)->get()[0]->id;

        PaymentDetail::record($user_id, 'deposit', 'gift', 500, '');

        return Helpers::result(true, 'You\'ve successfully registered', '200');
    }
}
