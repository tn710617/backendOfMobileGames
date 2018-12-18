<?php

namespace App\Http\Controllers;

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
        if ($failMessage = User::validation($toBeValidated, $request))
        {
            return ['result' => 'false', 'response' => $failMessage];
        }

        User::forceCreate([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return ['result' => 'true', 'response' => 'You\'ve successfully registered'];
    }
}
