<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Achieved extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
    ];

    public function type()
    {
        return $this->hasOne('App\Type');
    }


    public static function executeByType($request, $type)
    {
        switch ($type)
        {
            case 'one-time':

                if (!Helpers::whetherExists(new self(), new Achievement(), $request))
                {
                    Helpers::recordOneTimeStuff(new self(), new Achievement(), $request);

                    return User::result(true, Achievement::getAchievementName($request->achievement_id)
                        . ' has been achieved');
                }

                return User::result(false, Achievement::getAchievementName($request->achievement_id)
                    . ' was already achieved');
                break;

            case 'aggregatable':
                // If called achievement hasn't been achieved yet
                if (!Helpers::whetherExists(new Achieved(), new Achievement(), $request))
                {
                    Helpers::recordOneTimeStuff(new Achieved, new Achievement(), $request);

                    return User::result(true, Achievement::getAchievementName($request->achievement_id) . ' has been achieved');
                }

                Achieved::updateNumberOfPersonalAchievement($request);

                if (Achievement::whetherMutualAchievementExists($request))
                {
                    if (!Achieved::whetherMutualAchievementEverInserted($request))
                    {
                        $commonAchievementsWithTheSameMutualAchievementId =
                            CommonAchievement::getAllOfTheCommonAchievementsWithTheSameMutualAchievementId($request);
                        CommonlyAchieved::createCommonAchievementRecords($commonAchievementsWithTheSameMutualAchievementId, $request);
                    }

                    CommonlyAchieved::countAndReturnWhenCommonAchievementAchieved($request);

                }

                return User::result(true, Achievement::getAchievementName($request->achievement_id) . ' has been achieved');
                break;
        }
    }

    public static function updateNumberOfPersonalAchievement($request)
    {
        $Achieved = new Achieved;
        $Achieved = $Achieved->where('user_id', User::getUserId($request->token))->where('achievement_id', $request->achievement_id)->first();

        $Achieved->update(['number' => $Achieved->number + 1]);
    }

    public static function whetherMutualAchievementEverInserted($request)
    {
        return CommonlyAchieved::where('user_id', User::getUserId($request->token))->where('mutual_achievement_id', Achievement::getMutualAchievementNumber($request))->count();
    }

}
