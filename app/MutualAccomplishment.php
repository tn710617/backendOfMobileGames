<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MutualAccomplishment extends Model
{
    public static function getTotalNumberOfFindingLittleMan (Request $request)
    {
        $user_id = User::where('api_token', $request->token)->first()->id;
        $NumberOfFindingLittleManForLoveLetterGenerator = LoveLetterGenerator::where('user_id', $user_id)->first()->FindLittleMan;

        $NumberOfFindingLittleManForEscapeRoom =EscapeRoom::where('user_id', $user_id)->first()->FindLittleMan;
        $NumberOfFindingLittleManForGifStop = GifStop::where('user_id', $user_id)->first()->FindLittleMan;

        return $NumberOfFindingLittleManForEscapeRoom + $NumberOfFindingLittleManForGifStop + $NumberOfFindingLittleManForLoveLetterGenerator;
    }

    public static function whetherAccomplishmentAchieved ($user_id, $column)
    {
        return MutualAccomplishment::where('user_id', $user_id)->first()->$column;
    }
}
