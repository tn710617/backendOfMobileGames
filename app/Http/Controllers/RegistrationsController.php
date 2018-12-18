<?php

namespace App\Http\Controllers;

use App\EscapeRoom;
use App\GifStop;
use App\LoveLetterGenerator;
use App\MutualAccomplishment;
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
            'password' => 'required|min:6|max:255'
        ]);

        $user = User::forceCreate([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        auth()->login($user);

        LoveLetterGenerator::forceCreate([
            'user_id' => auth()->id(),
        ]);
        EscapeRoom::forceCreate([
            'user_id' => auth()->id(),
        ]);
        GifStop::forceCreate([
            'user_id' => auth()->id(),
        ]);

        MutualAccomplishment::forceCreate([
            'user_id' => auth()->id(),
        ]);
        return redirect()->home();
    }


}
