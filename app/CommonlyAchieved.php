<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommonlyAchieved extends Model
{
    protected $fillable = [
        'number',
        'status'
    ];
    //
    public static function createCommonAchievementRecords($commonAchievementsWithTheSameMutualAchievementId, $request)
    {
        foreach ($commonAchievementsWithTheSameMutualAchievementId as $toBeInserted)
        {
            $commonlyAchieved = new CommonlyAchieved();
            $commonlyAchieved->forceCreate([
                'user_id'               => User::getUserId($request->bearerToken()),
                'common_achievement_id' => $toBeInserted->id,
                'mutual_achievement_id' => $toBeInserted->mutual_achievement_id,
                'number'                => $toBeInserted->number,
            ]);
        }

    }

    public static function countAndReturnWhenCommonAchievementAchieved($request, Model $binding)
    {
        $commonlyAchieved = new CommonlyAchieved();
        $toBeUpdateds = $commonlyAchieved
            ->where('user_id', User::getUserId($request->bearerToken()))
            ->where('mutual_achievement_id', $binding->mutual_achievement_id)
            ->get();
        $isCommonAchievementAchieved = false;
        foreach ($toBeUpdateds as $toBeUpdated)
        {
            if ($toBeUpdated->number > - 1)
                $toBeUpdated->update([
                    'number' => $toBeUpdated->number - 1,
                ]);

            if (($toBeUpdated->number == 0) && ($toBeUpdated->status !== 1))
            {
                $toBeUpdated->update(['status' => 1]);
                $response = CommonAchievement::find($toBeUpdated->common_achievement_id)
                        ->name . ' has been achieved';
                $isCommonAchievementAchieved = true;
            }

        }
        if ($isCommonAchievementAchieved)
        {
            return $response;
        }
    }

    public static function achieveDepositAchievement($amountOfDepositing, $user_id)
    {
        $commonAchievementsOfDepositing = CommonAchievement::where('mutual_achievement_id', 99)->get();
        foreach ($commonAchievementsOfDepositing as $commonAchievementOfDepositing)
        {
            if ($commonAchievementOfDepositing->number <= $amountOfDepositing)
            {
                $whetherCommonAchievementExists = CommonlyAchieved::where('user_id', $user_id)->where('common_achievement_id', $commonAchievementOfDepositing->id)->count();
                if ($whetherCommonAchievementExists == 0)
                {
                    CommonlyAchieved::forceCreate([
                        'user_id' => $user_id,
                        'common_achievement_id' => $commonAchievementOfDepositing->id,
                        'mutual_achievement_id' => 99,
                        'number' => $commonAchievementOfDepositing->number,
                        'status' => 1,
                    ]);
                }

            }
        }
    }
}




