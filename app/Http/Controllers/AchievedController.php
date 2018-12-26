<?php

namespace App\Http\Controllers;

use App\Achieved;
use App\Achievement;
use App\Type;
use Illuminate\Http\Request;

class AchievedController extends Controller {

    public function achieved(Request $request)
    {
        $type = Type::getType(new Achievement, $request);

        return Achieved::executeByType($request, $type);
    }
}
