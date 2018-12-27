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
        if (Type::getType(new Item, $request->item_id) !== 'aggregatable')
        {
            User::result('false', 'invalid operation');
        }

        return '123';

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
        $purchased = (new Purchased())->where('user_id', User::getUserId($request->token))
            ->where('item_id', $request->item_id)->first();

        return $purchased->where('user_id', User::getUserId($request->token))
            ->where('item_id', $request->item_id)
            ->update([
                'user_id' => User::getUserId($request->token),
                'item_id' => $request->item_id,
                'number'  => $purchased->number + $request->number,
            ]);
    }
}
