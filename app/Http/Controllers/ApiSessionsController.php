<?php

namespace App\Http\Controllers;

use App\Achieved;
use App\Game;
use App\Helpers;
use App\Purchased;
use App\User;
use Illuminate\Http\Request;

class ApiSessionsController extends Controller {

    public function show(Request $request)
    {
        $toBeValidated = [
            'game_id' => 'required'
        ];

        if ($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage);
        }

        if(Helpers::whetherIDExists($request->game_id, new Game()) === false)
        {
            return Helpers::result(false, 'Invalid game_id');
        }

        $user = (new User())->find(User::getUserId($request->token));
        $remainingPoints = $user->remainingPoints;
        $email = $user->email;
        $achievedAchievement = Achieved::getAchieved($request);
        $possessions = Purchased::getPossessedItems($request);
        $response = ['email'               => $email,
                     'remainingPoints'     => $remainingPoints,
                     'achievedAchievement' => $achievedAchievement,
                     'possessions'         => $possessions,
        ];

        return Helpers::result(true, $response);
    }

}
