<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\Game;
use App\Helpers;

class AchievementController extends Controller {

    public function show(Game $game = null)
    {
        $response = [];
        $datas = Achievement::where('game_id', $game->id)->get();
        foreach($datas as $data)
        {
            $type = $data->type->name;
            $response[$type][] = $data->only('id', 'name');
        }

        return Helpers::result(true, $response);
    }
}
