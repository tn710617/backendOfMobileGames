<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Helpers {

    public static function whetherIDExists($id, Model $model)
    {
        if($model::where('id', $id)->count() < 1)
        {
            return false;
        }
        return true;
    }

    public static function whetherExists(Model $model1, Model $model2, $request)
    {
        $id = substr(strtolower(get_class($model2)) . '_id', 4);
        return $model1::where('user_id', User::getUserId($request->token))
                ->where($id, $request->$id)
                ->count() > 0;
    }

    public static function recordOneTimeStuff(Model $model1, Model $model2, Request $request)
    {
        $id = substr(strtolower(get_class($model2)) . '_id', 4);
        $model1::forceCreate([
            'user_id' => User::getUserId($request->token),
            'number'  => 1,
            $id       => $request->$id,
            'status'  => 1,
        ]);
    }

    public static function switchHasBetweenSingularAndPlural($number)
    {
        if ($number > 1)
        {
            return 'have';
        }
        return 'has';
    }

    public static function result($result, $response)
    {
        return ['result' => $result, 'response' => $response];
    }

    public static function validation(Array $toBeValidated, Request $request)
    {
        $validator = validator::make($request->all(), $toBeValidated);
        if ($validator->fails())
        {
            return $validator->errors()->first();
        }
    }

    public static function uniqueTokenCreator()
    {
        $checkIfTokenExists = 1;
        while ($checkIfTokenExists)
        {
            $uniqueToken = str_random(60);
            $checkIfTokenExists = User::where('api_token', $uniqueToken)->count();
        }

        return $uniqueToken;
    }

    public static function whetherRemainingPointsAreEnough($request, $number = 1)
    {
        if (User::getTotalRemainingPoints(User::getUserId($request->token))
            <
            (Item::getItemCost(User::getUserId($request->token))) * $number)
        {
            return false;
        }
        return true;
    }
}
