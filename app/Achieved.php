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


    public static function executeByType($type, Model $binding, Request $request)
    {

        switch ($type)
        {
            case 'one-time':

                if (!Helpers::whetherExists(new self(), $binding, $request->bearerToken()))
                {
                    Helpers::recordOneTimeStuff(new self(), $binding, $request);

                    return Helpers::result(true, $binding->name
                        . ' has been achieved');
                }

                return Helpers::result(false, $binding->name
                    . ' was already achieved');
                break;

            case 'aggregatable':
                if (!Helpers::whetherExists(new self(), $binding, $request->bearerToken()))
                {
                    Helpers::recordOneTimeStuff(new self(), $binding, $request);

                    return Helpers::result(true, $binding->name . ' has been achieved');
                }

                Achieved::updateNumberOfPersonalAchievement($request, $binding);

                if ($binding->mutual_achievement_id)
                {
                    if (!Achieved::whetherMutualAchievementEverInserted($request, $binding))
                    {
                        $commonAchievementsWithTheSameMutualAchievementId =
                            CommonAchievement::getAllOfTheCommonAchievementsWithTheSameMutualAchievementId($binding);
                        CommonlyAchieved::createCommonAchievementRecords($commonAchievementsWithTheSameMutualAchievementId, $request);
                    }

                    $response = CommonlyAchieved::countAndReturnWhenCommonAchievementAchieved($request, $binding);
                    if ($response)
                    {
                        return Helpers::result(true, $response);
                    }

                }

                return Helpers::result(true, $binding->name . ' has been achieved');
                break;
        }
    }

    public static function updateNumberOfPersonalAchievement($request, $binding)
    {
        $Achieved = new Achieved;
        $Achieved = $Achieved->where('user_id', User::getUserId($request->bearerToken()))->where('achievement_id', $binding->id)->first();

        $Achieved->update(['number' => $Achieved->number + 1]);
    }

    public static function whetherMutualAchievementEverInserted($request, Model $binding)
    {
        return CommonlyAchieved::where('user_id', User::getUserId($request->bearerToken()))->where('mutual_achievement_id', $binding->mutual_achievement_id)->count();
    }

    public static function getAchieved($request)
    {
        $response = [];
        $achieveds = (new Achieved())->where('user_id', User::getUserId($request->token))
            ->get();
        foreach ($achieveds as $achieved)
        {
            $type = Achievement::find($achieved->achievement_id)->type->name;
            if (Achievement::find($achieved->achievement_id)->game_id == $request->game_id)
            {
                if ($type == 'one-time')
                {
                    $response[$type]['achievement_id'][] = $achieved->achievement_id;
                    continue;
                }
                $response[$type][] = $achieved->only('achievement_id', 'number');
            }
        }

        $commonlyAchieveds = (new CommonlyAchieved())->where('user_id', User::getUserId($request->token))
            ->get();

        foreach ($commonlyAchieveds as $commonlyAchieved)
        {
            $type = CommonAchievement::find($commonlyAchieved->common_achievement_id)->type->name;
            if ($commonlyAchieved->status == 1)
            {
                if ($type == 'one-time')
                {
                    $response[$type]['common_achievement_id'][] = $commonlyAchieved->common_achievement_id;
                    continue;
                }
                $response[$type][] = $commonlyAchieved->only('common_achievement_id', 'number');
            }
        }

        return $response;
    }

}
