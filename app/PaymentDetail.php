<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    public static function record($user_id, $motion, $item, $amount, $game)
    {
        $user = new User;

        $user = $user->find($user_id);
        if ($motion == 'consume')
        {
            $user->where('id', $user_id)->update(['remainingPoints' => ($user->remainingPoints - $amount)]);
        }
        if ($motion == 'deposit')
        {
            $user->where('id', $user_id)->update(['remainingPoints' => ($user->remainingPoints + $amount)]);
        }

        PaymentDetail::forceCreate([
            'user_id' => $user_id,
            'game' => $game,
            'motion' => $motion,
            'item' => $item,
            'amount' => $amount,
            'remainingPoints' => User::getTotalRemainingPoints($user_id),
        ]);

    }

}
