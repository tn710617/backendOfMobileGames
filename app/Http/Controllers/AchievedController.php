<?php

namespace App\Http\Controllers;

use App\Achieved;
use App\Achievement;
use App\Helpers;
use App\Type;
use Illuminate\Http\Request;

class AchievedController extends Controller {

    public function achieve(Request $request)
    {
        $toBeValidated = [
            'achievement_id' => 'required',
        ];
        if($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage);
        }

        if(Helpers::whetherIDExists($request->achievement_id, new Achievement()) == false)
        {
            return Helpers::result(false, 'Invalid Achievement_id');
        }
        $type = Type::getType(new Achievement, $request);

        return Achieved::executeByType($request, $type);
    }

    public function showAchieved(Request $request)
    {
        return Achieved::getAchieved($request);
    }

}
