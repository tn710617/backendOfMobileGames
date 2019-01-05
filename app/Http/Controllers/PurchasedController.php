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


    public function use(Request $request)
    {
        $toBeValidated = [
            'item_id' => 'required',
            'number' => 'required'
        ];
        if ($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage);
        }

        if(Helpers::whetherIDExists($request->item_id, new Item()) === false)
        {
            return Helpers::result(false, 'Invalid item_id');
        }

        return Purchased::use($request);
    }

    public function possessions(Request $request)
    {
        $toBeValidated = [
            'game_id' => 'required',
        ];
        if ($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage);
        }

        if(Helpers::whetherIDExists($request->game_id, new Game()) === false)
        {
            return Helpers::result(false, 'Invalid game_id');
        }
        $response = Purchased::getPossessedItems($request);

        return Helpers::result(true, $response);
    }
}
