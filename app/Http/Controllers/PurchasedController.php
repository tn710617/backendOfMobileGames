<?php

namespace App\Http\Controllers;

use App\Item;
use App\Purchased;
use App\Type;
use Illuminate\Http\Request;

class PurchasedController extends Controller {

    public function purchased(Request $request)
    {
        $type = Type::getType(new Item(), $request);

        return Purchased::executeByType($request, $type);
    }


    public function use(Request $request)
    {
        return Purchased::use($request);
    }

    public function possessions(Request $request)
    {
        return Purchased::getPossessedItems($request);
    }
}
