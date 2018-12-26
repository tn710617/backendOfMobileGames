<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommonAchievement extends Model
{
    //
    public static function getAllOfTheCommonAchievementsWithTheSameMutualAchievementId($request)
    {
        $commonAchievements = new CommonAchievement();
        return $commonAchievements
            ->where('mutual_achievement_id', Achievement::getMutualAchievementNumber($request))
            ->get();
    }
}
