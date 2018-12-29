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
