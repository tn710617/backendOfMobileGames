<?php

namespace App\Http\Controllers;

use App\PaymentDetail;
use App\Possession;
use App\Shop;
use App\User;
use Illuminate\Http\Request;

class ShopController extends Controller {

    public function show(Request $request)
    {
        $itemDetails = Shop::where('game', $request->game)->get();
        $everything = [];
        foreach ($itemDetails as $itemDetail)
        {
            $everything[$itemDetail->item] = ['cost' => $itemDetail->cost, 'id' => $itemDetail->id];
        }

        return ['result' => 'true', 'response' => $everything];
    }

    public function update(Request $request)
    {
        $user_id = User::getUserId($request->token);
        if (User::getTotalRemainingPoints($user_id) < 100)
        {
            return ["result" => "false",
    "response" => "Your remaining point is not enough"];
        }
            if (Possession::where('user_id', $user_id)->where('item', $request->item)->get()->count() > 0)
        {
            return ['result' => 'false', 'response' => 'item has already been purchased'];
        } else
        {
            Possession::forceCreate([
                'user_id' => $user_id,
                'number'  => 1,
                'item'    => $request->item,
            ]);
            $game = Shop::where('id', $request->item)->first()->game;
            $currentPoints = User::getTotalRemainingPoints($user_id);
            $cost = Shop::where('id', $request->item)->first()->cost;
            User::where('id', $user_id)->update(['RemainingPoints' => $currentPoints - $cost]);
            PaymentDetail::forceCreate([
                'user_id'         => $user_id,
                'game'            => $game,
                'item'            => 'purchasing',
                'amount'          => $cost,
                'motion'          => 'deduct',
                'remainingPoints' => User::getTotalRemainingPoints($user_id),

            ]);

            return ['result'          => 'true',
                    'response'        => $request->item,
                    'remainingPoints' => User::getTotalRemainingPoints($user_id)];
        }


    }
}
