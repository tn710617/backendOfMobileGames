<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Purchased extends Model {

    public static function executeByType($request, $type)
    {
        switch ($type)
        {
            case 'one-time':
                if (!Helpers::whetherExists(new self(), new Item(), $request))
                {
                    Helpers::recordOneTimeStuff(new self(), new Item(), $request);

                    return User::result(true, Item::getItemName($request->item_id)
                        . ' has been purchased');
                }

                return User::result(false, item::getItemName($request->item_id)
                    . ' was already purchased');
                break;


            case 'aggregatable':
                $hasOrHave = Helpers::switchHasBetweenSingularAndPlural($request->number);
                if (!Helpers::whetherExists(new self(), new Item(), $request))
                {
                    Purchased::recordAggregatableStuff($request);

                    return User::result(true, Item::getItemName($request->item_id) . ' * ' . $request->number
                        . " $hasOrHave been purchased");
                }

                Purchased::updateAggregatableStuff($request);

                return User::result(true, Item::getItemName($request->item_id) . ' * ' . $request->number
                    . " $hasOrHave been purchased");

                break;
        }
    }

    public static function use(Request $request)
    {
        if (Type::getType(new Item, $request) !== 'aggregatable')
        {
            return User::result('false', 'invalid operation');
        }
        if (Purchased::getItemNumber($request) < $request->number)
        {
            return User::result('false', 'Required quantity is not enough');
        }

        Purchased::updateAggregatableStuff($request);
        $hasOrHave = Helpers::switchHasBetweenSingularAndPlural($request->number);
        return User::result(true, Item::getItemName($request->item_id) . ' * ' . $request->number
            . " $hasOrHave been used");

    }

    public static function getItemNumber($request)
    {
        return Purchased::where('user_id', User::getUserId($request->token))
            ->where('item_id', $request->item_id)
            ->first()->number;
    }

    public static function recordAggregatableStuff($request)
    {
        Purchased::forceCreate([
            'user_id' => User::getUserId($request->token),
            'item_id' => $request->item_id,
            'number'  => $request->number,
        ]);
    }

    public static function updateAggregatableStuff($request)
    {
        $type = substr($_SERVER['REQUEST_URI'], 5);

        $purchased = (new Purchased())->where('user_id', User::getUserId($request->token))
            ->where('item_id', $request->item_id)->first();

        return $purchased->where('user_id', User::getUserId($request->token))
            ->where('item_id', $request->item_id)
            ->update(['number' => ($type == 'use')
                ? ($purchased->number - $request->number)
                : ($purchased->number + $request->number)]);
    }
}
