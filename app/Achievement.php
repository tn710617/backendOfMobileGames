<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public static function getMutualAchievementNumber($request)
    {
        return Achievement::find($request->achievement_id)->mutual_achievement_id;
    }


    public static function whetherMutualAchievementExists($request)
    {
        return Achievement::find($request->achievement_id)->mutual_achievement_id;
    }

    public static function getAchievementName($achievement_id)
    {
        return Achievement::find($achievement_id)->name;
    }
}
