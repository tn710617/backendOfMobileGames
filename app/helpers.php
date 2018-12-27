<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class helpers {

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
}
