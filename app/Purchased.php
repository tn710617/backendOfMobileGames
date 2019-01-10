<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Purchased extends Model {

    public static function executeByType(Request $request, $type, Model $binding)
    {
        switch ($type)
        {
            case 'one-time':
                if (Helpers::whetherRemainingPointsAreEnough($request->bearerToken()) == false)
                {
                    return Helpers::result(false, 'Your remaining points are not enough', 400);
                }

                if (!Helpers::whetherExists(new self(), $binding, $request->bearerToken()))
                {
                    Helpers::recordOneTimeStuff(new self(), $binding, $request);
                    PaymentDetail::record(User::getUserId($request->bearerToken()),
                        'consume',
                        Item::getItemName($binding->id),
                        Item::getItemCost($binding->id),
                        Item::getGameName($binding->id));

                    return Helpers::result(true, Item::getItemName($binding->id)
                        . ' has been purchased', 200);
                }

                return Helpers::result(false, item::getItemName($binding->id)
                    . ' was already purchased', 400);
                break;


            case 'aggregatable':

                if (Helpers::whetherRemainingPointsAreEnough($request->bearerToken(), $request->number) === false)
                {
                    return Helpers::result(false, 'Your remaining points are not enough', 400);
                }

                $hasOrHave = Helpers::switchHasBetweenSingularAndPlural($request->number);

                PaymentDetail::record(User::getUserId($request->bearerToken())
                    , 'consume'
                    , Item::getItemName($binding->id)
                    , Item::getItemCost($binding->id) * $request->number
                    , Item::getGameName($binding->id));


                if (!Helpers::whetherExists(new self(), $binding, $request->bearerToken()))
                {
                    Purchased::recordAggregatableStuff($request, $binding);

                    PaymentDetail::record(User::getUserId($request->bearerToken()),
                        'consume',
                        Item::getItemName($binding->id),
                        Item::getItemCost($binding->id) * $request->number,
                        Item::getGameName($binding->id));

                    return Helpers::result(true, $binding->name . ' * ' . $request->number
                        . " $hasOrHave been purchased", 200);
                }

                Purchased::updateAggregatableStuff($request->number, $request->bearerToken(), $binding);

                return Helpers::result(true, $binding->name . ' * ' . $request->number
                    . " $hasOrHave been purchased", 200);

                break;
        }
    }

    public static function use(Request $request, Model $binding)
    {
        if (Type::getType($binding) !== 'aggregatable')
        {
            return Helpers::result(false, 'invalid operation', 400);
        }
        if (Purchased::getItemNumber($request->bearerToken(), $binding) < $request->number)
        {
            return Helpers::result(false, 'Required quantity is not enough', 400);
        }

        $number = (-$request->number);
        Purchased::updateAggregatableStuff($number, $request->bearerToken(), $binding);
        $hasOrHave = Helpers::switchHasBetweenSingularAndPlural($request->number);

        return Helpers::result(true, Item::getItemName($binding->id) . ' * ' . $request->number
            . " $hasOrHave been used", 200);

    }

    public static function getItemNumber($token, Model $binding)
    {
        return Purchased::where('user_id', User::getUserId($token))
            ->where('item_id', $binding->id)
            ->first()->number;
    }

    public static function recordAggregatableStuff($request, Model $binding)
    {
        Purchased::forceCreate([
            'user_id' => User::getUserId($request->bearerToken()),
            'item_id' => $binding->id,
            'number'  => $request->number,
        ]);
    }

    public static function updateAggregatableStuff($number, $token, Model $binding)
    {
        $purchased = (new Purchased())->where('user_id', User::getUserId($token))
            ->where('item_id', $binding->id)->first();

        return $purchased->where('user_id', User::getUserId($token))
            ->where('item_id', $binding->id)
            ->update(['number' => $purchased->number + $number]);
    }

    public static function getPossessedItems($token, Model $binding)
    {
        $response = [];
        $possessions = (new Purchased())->where('user_id', User::getUserId($token))
            ->get();
        foreach ($possessions as $possession)
        {
            $type = Item::find($possession->item_id)->type->name;
            if(Item::find($possession->item_id)->game_id == $binding->id)
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
