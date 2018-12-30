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
                if (Helpers::whetherRemainingPointsAreEnough($request) == false)
                {
                    return Helpers::result(false, 'Your remaining points are not enough');
                }

                $item_id = $request->item_id;
                if (!Helpers::whetherExists(new self(), new Item(), $request))
                {
                    Helpers::recordOneTimeStuff(new self(), new Item(), $request);
                    PaymentDetail::record(User::getUserId($request->token),
                        'consume',
                        Item::getItemName($item_id),
                        Item::getItemCost($item_id),
                        Item::getGameName($item_id));

                    return Helpers::result(true, Item::getItemName($item_id)
                        . ' has been purchased');
                }

                return Helpers::result(false, item::getItemName($item_id)
                    . ' was already purchased');
                break;


            case 'aggregatable':
                if (Helpers::whetherRemainingPointsAreEnough($request, $request->number) === false)
                {
                    return Helpers::result(false, 'Your remaining points are not enough');
                }

                $hasOrHave = Helpers::switchHasBetweenSingularAndPlural($request->number);

                PaymentDetail::record(User::getUserId($request->token)
                    , 'consume'
                    , Item::getItemName($request->item_id)
                    , Item::getItemCost($request->item_id) * $request->number
                    , Item::getGameName($request->item_id));

                if (!Helpers::whetherExists(new self(), new Item(), $request))
                {
                    Purchased::recordAggregatableStuff($request);

                    PaymentDetail::record(User::getUserId($request->token),
                        'consume',
                        Item::getItemName($request->item_id),
                        Item::getItemCost($request->item_id) * $request->number,
                        Item::getGameName($request->item_id));

                    return Helpers::result(true, Item::getItemName($request->item_id) . ' * ' . $request->number
                        . " $hasOrHave been purchased");
                }

                Purchased::updateAggregatableStuff($request);

                return Helpers::result(true, Item::getItemName($request->item_id) . ' * ' . $request->number
                    . " $hasOrHave been purchased");

                break;
        }
    }

    public static function use(Request $request)
    {
        if (Type::getType(new Item, $request) !== 'aggregatable')
        {
            return Helpers::result(false, 'invalid operation');
        }
        if (Purchased::getItemNumber($request) < $request->number)
        {
            return Helpers::result(false, 'Required quantity is not enough');
        }

        Purchased::updateAggregatableStuff($request);
        $hasOrHave = Helpers::switchHasBetweenSingularAndPlural($request->number);

        return Helpers::result(true, Item::getItemName($request->item_id) . ' * ' . $request->number
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

    public static function getPossessedItems($request)
    {
        $response = [];
        $possessions = (new Purchased())->where('user_id', User::getUserId($request->token))
            ->get();
        foreach ($possessions as $possession)
        {
            $type = Item::find($possession->item_id)->type->name;
            if(Item::find($possession->item_id)->game_id == $request->game_id)
            {
                if($type == 'one-time')
                {
                    $response[$type]['item_id'][] = $possession->item_id;
                    continue;
                }
                $response[$type] = $possession->only('item_id', 'number');
            }
        }

        return $response;
    }

}
