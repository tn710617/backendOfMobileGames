<?php

namespace App\Http\Controllers;

use App\Achieved;
use App\Game;
use App\Helpers;
use App\Purchased;
use App\User;
use Illuminate\Http\Request;

class ApiSessionsController extends Controller {

    public function show(Request $request, Game $game)
    {
        $user = (new User())->find(User::getUserId($request->bearerToken()));
        $remainingPoints = $user->remainingPoints;
        $email = $user->email;
        $achievedAchievement = Achieved::getAchieved($request, $game);
        $possessions = Purchased::getPossessedItems($request->bearerToken(), $game);
        $response = ['email'               => $email,
                     'remainingPoints'     => $remainingPoints,
                     'achievedAchievement' => $achievedAchievement,
                     'possessions'         => $possessions,
        ];

        return Helpers::result(true, $response);
    }

}
