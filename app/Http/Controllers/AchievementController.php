<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\Helpers;
use App\User;
use Illuminate\Http\Request;

class AchievementController extends Controller {

    public function show(Request $request)
    {
        $toBeValidated = [
            'game_id' => 'required'
        ];
        if($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage);
        }

        $data = Achievement::where('game_id', $request->game_id)->select('id', 'name')->get();

        return Helpers::result(true, $data);
    }
}
