<?php

namespace App\Http\Controllers;

use App\Achieved;
use App\Achievement;
use App\Type;
use Illuminate\Http\Request;

class AchievedController extends Controller {

    public function achieve(Request $request)
    {
        $type = Type::getType(new Achievement, $request);

        return Achieved::executeByType($request, $type);
    }

    public function showAchieved(Request $request)
    {
        return Achieved::getAchieved($request);
    }

}
