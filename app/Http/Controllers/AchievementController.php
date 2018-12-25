<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\User;
use Illuminate\Http\Request;

class AchievementController extends Controller {

    public function show(Request $request)
    {
        $toBeValidated = [
            'game_id' => 'required'
        ];
        if($failMessage = User::validation($toBeValidated, $request))
        {
            return User::result(false, $failMessage);
        }

        $data = Achievement::where('game_id', $request->game_id)->select('id', 'achievement')->get();

        return User::result(true, $data);
    }
}
