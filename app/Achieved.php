<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Achieved extends Model {

    public function type()
    {
        return $this->hasOne('App\Type');
    }

    public function executeByType($request, $type)
    {
        $user_id = User::getUserId($request->token);
        switch ($type)
        {
            case 'one-time':
                if (!Achieved::where('user_id', $user_id)
                        ->where('achievement_id', $request->achievement_id)
                        ->count() > 0)
                {
//                    Achieved::forceCreate([
//                        'user_id' => $user_id,
//                        'achievement_id' =>
//                    ]);
                }


                break;

            case 'aggregatable':


                break;
        }
    }
}
