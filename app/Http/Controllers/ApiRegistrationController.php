<?php

namespace App\Http\Controllers;

use App\EscapeRoom;
use App\GifStop;
use App\LoveLetterGenerator;
use App\MutualAccomplishment;
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

        $userId = User::where('email', $request->email)->first()->id;
        LoveLetterGenerator::forceCreate([
            'user_id' => $userId,
        ]);
        EscapeRoom::forceCreate([
            'user_id' => $userId,
        ]);
        GifStop::forceCreate([
            'user_id' => $userId,
        ]);

        MutualAccomplishment::forceCreate([
            'user_id' => $userId,
        ]);
//        return response()->json(['result' => 'true', 'response' => 'You\'ve successfully registered'], 200, ['content-length' => '72']);
        return ['result' => 'true', 'response' => 'You\'ve successfully registered'];
    }
}
