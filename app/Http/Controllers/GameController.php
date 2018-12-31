<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers;
use App\PaymentDetail;
use App\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function play(Request $request)
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

        $game = (new Game())->find($request->game_id)->first();
        if(User::getTotalRemainingPoints(User::getUserId($request->token)) < $game->cost)
        {
            return Helpers::result(false, 'Your remaining points are not enough');
        }

        PaymentDetail::record(User::getUserId($request->token)
        ,'consume'
        ,''
        ,$game->cost
        ,$game->name);

        $response = ['remainingPoints' => User::getTotalRemainingPoints(User::getUserId($request->token))];
        return Helpers::result(true, $response);
    }
}
