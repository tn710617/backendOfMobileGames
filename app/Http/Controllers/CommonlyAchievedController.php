<?php

namespace App\Http\Controllers;

use App\CommonlyAchieved;
use App\Helpers;
use App\User;
use Illuminate\Http\Request;

class CommonlyAchievedController extends Controller
{
    public function achieveDepositAchievement(Request $request)
    {
            CommonlyAchieved::commonAchievementOfDeposit($request->number, User::getUserId($request->token));
    }
}
