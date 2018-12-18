<?php

namespace App\Http\Controllers;

use App\MutualAccomplishment;
use App\PaymentDetail;
use App\User;
use Illuminate\Http\Request;

class PaymentDetailController extends Controller {

    public function deduct(Request $request)
    {
        $user_id = User::where('api_token', $request->token)->first()->id;
        switch ($request->game)
        {
            case 'escapeRoom':
                if(User::getTotalRemainingPoints($user_id) < 10)
                {
                    return ['result' => 'false', 'response' => 'Your remaining point is not enough'];
                }
                PaymentDetail::forceCreate([
                    'user_id'         => $user_id,
                    'game'            => $request->game,
                    'deduct'          => 10,
                    'remainingPoints' => User::getTotalRemainingPoints($user_id) - 10,
                ]);
                User::where('id', $user_id)->update(['RemainingPoints'
                                                     => User::getTotalRemainingPoints($user_id) - 10]);

                return ['result' => 'true', 'response' => User::getTotalRemainingPoints($user_id)];
                break;

            case 'loveLetterGenerator':
                if(User::getTotalRemainingPoints($user_id) < 10)
                {
                    return ['result' => 'false', 'response' => 'Your remaining point is not enough'];
                }
                PaymentDetail::forceCreate([
                    'user_id'         => $user_id,
                    'game'            => $request->game,
                    'deduct'          => 10,
                    'remainingPoints' => User::getTotalRemainingPoints($user_id) - 10,
                ]);
                User::where('id', $user_id)->update(['RemainingPoints'
                                                     => User::getTotalRemainingPoints($user_id) - 10]);

                return ['result' => 'true', 'response' => User::getTotalRemainingPoints($user_id)];
                break;

            case 'gifStop':
                if(User::getTotalRemainingPoints($user_id) < 10)
                {
                    return ['result' => 'false', 'response' => 'Your remaining point is not enough'];
                }
                PaymentDetail::forceCreate([
                    'user_id'         => $user_id,
                    'game'            => $request->game,
                    'deduct'          => 10,
                    'remainingPoints' => User::getTotalRemainingPoints($user_id) - 10,
                ]);
                User::where('id', $user_id)->update(['RemainingPoints'
                                                     => User::getTotalRemainingPoints($user_id) - 10]);

                return ['result' => 'true', 'response' => User::getTotalRemainingPoints($user_id)];
                break;
        }

    }
}
