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
            $type = $data->type->name;
            $response[$type][] = $data->only(['id', 'name']);
        }

        return Helpers::result(true, $response, 200);
    }
}
