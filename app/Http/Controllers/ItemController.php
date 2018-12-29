<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Item;
use App\User;
use Illuminate\Http\Request;

class ItemController extends Controller {


    public function show(Request $request)
    {
        $toBeValidated = [
            'game_id' => 'required'
        ];

        if ($failMessage = Helpers::validation($toBeValidated, $request))
        {
           return Helpers::result(false, $failMessage);
        }
        $data = Item::where('game_id', $request->game_id)->select('id', 'name', 'cost')->get();

        return Helpers::result(true, $data);
    }


}
