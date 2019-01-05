<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers;
use App\Item;
use App\Purchased;
use App\Type;
use App\User;
use Illuminate\Http\Request;

class PurchasedController extends Controller {

    public function purchased(Request $request, Item $item)
    {
        $type = Type::getType($item);

        return Purchased::executeByType($request, $type, $item);
    }


    public function use(Request $request, Item $item)
    {
        $toBeValidated = [
            'number' => 'required'
        ];
        if ($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage);
        }

        return Purchased::use($request, $item);
    }

    public function possessions(Request $request, Game $game)
    {
        if(!$game->id)
        {
            return Helpers::result(false, 'Invalid game_id');
        }
        $response = Purchased::getPossessedItems($request->bearerToken(), $game);

        return Helpers::result(true, $response);
    }
}
