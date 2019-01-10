<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers;
use App\Item;
use App\User;
use Illuminate\Http\Request;

class ItemController extends Controller {


    public function show(Game $game)
    {
        $response = [];

        $datas = Item::where('game_id', $game->id)->get();
        foreach($datas as $data)
        {
            $type = $data->type->name;
            $response[$type][] = $data->only('id', 'name', 'cost');
        }

        return Helpers::result(true, $response, 200);
    }


}
