<?php

namespace App\Http\Controllers;

use App\Game;
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

        if(Helpers::whetherIDExists($request->game_id, new Game()) === false)
        {
            return Helpers::result(false, 'Invalid game_id');
        }

        $response = [];

        $datas = Item::where('game_id', $request->game_id)->get();
        foreach($datas as $data)
        {
            $type = $data->type->name;
            $response[$type][] = $data->only('id', 'name', 'cost');
        }

        return Helpers::result(true, $response);



    }


}
