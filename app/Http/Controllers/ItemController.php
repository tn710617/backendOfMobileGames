<?php

namespace App\Http\Controllers;

use App\Item;
use App\User;
use Illuminate\Http\Request;

class ItemController extends Controller {

    public function show(Request $request)
    {
        $toBeValidated = [
            'game_id' => 'required'
        ];

        if ($failMessage = User::validation($toBeValidated, $request))
        {
            return User::result(false, $failMessage);
        }
        $data = Item::where('game_id', $request->game_id)->select('id', 'item', 'cost')->get();

        return User::result(true, $data);
    }
}
