<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\Type;
use Illuminate\Http\Request;

class AchievedController extends Controller
{
    public function achieved (Request $request)
    {
         $type = Achievement::find($request->achievement_id)->type()->first()->type;


    }
}
