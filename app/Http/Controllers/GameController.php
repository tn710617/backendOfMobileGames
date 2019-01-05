<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers;
use App\PaymentDetail;
use App\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function play(Request $request, Game $game)
    {
        if(User::getTotalRemainingPoints(User::getUserId($request->bearerToken())) < $game->cost)
        {
            return Helpers::result(false, 'Your remaining points are not enough');
        }

        PaymentDetail::record(User::getUserId($request->bearerToken())
        ,'consume'
        ,''
        ,$game->cost
        ,$game->name);

        $response = ['remainingPoints' => User::getTotalRemainingPoints(User::getUserId($request->bearerToken()))];
        return Helpers::result(true, $response);
    }
}
