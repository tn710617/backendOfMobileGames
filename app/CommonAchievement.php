<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommonAchievement extends Model
{


    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public static function getAllOfTheCommonAchievementsWithTheSameMutualAchievementId($request)
    {
        $commonAchievements = new CommonAchievement();
        return $commonAchievements
            ->where('mutual_achievement_id', Achievement::getMutualAchievementNumber($request))
            ->get();
    }
}
