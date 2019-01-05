<?php

namespace App\Http\Controllers;

use App\Achieved;
use App\Achievement;
use App\Helpers;
use App\Type;
use Illuminate\Http\Request;

class AchievedController extends Controller {

    public function achieve(Request $request, Achievement $achievement)
    {
        $type = Type::getType($achievement);

        return Achieved::executeByType($type, $achievement, $request);
    }

    public function showAchieved(Request $request)
    {
        return Achieved::getAchieved($request);
    }

}
