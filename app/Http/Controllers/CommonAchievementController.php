<?php

namespace App\Http\Controllers;

use App\CommonAchievement;
use App\Helpers;
use Illuminate\Http\Request;

class CommonAchievementController extends Controller
{
    public function show()
    {
        $datas = CommonAchievement::all();
        $response = [];
        foreach ($datas as $data)
        {
            $response[] = $data->only(['id', 'name']);
        }

        return Helpers::result(true, $response);
    }
}
