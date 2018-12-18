<?php

namespace App\Http\Controllers;

use App\MutualAccomplishment;
use App\User;
use Illuminate\Http\Request;

class ApiSessionsController extends Controller {

    public function show(Request $request)
    {
        $user = new User;
        $user = $user->where('api_token', $request->token)->first();
        $user_id = $user->id;
        $email = $user->email;
        $remainingPoint = $user->RemainingPoints;
        $FindLittleMan = MutualAccomplishment::whetherAccomplishmentAchieved($user_id, 'FindLittleMan');
        $YouAreFilthyRich = MutualAccomplishment::whetherAccomplishmentAchieved($user_id, 'YouAreFilthyRich');

        return [
            'result'   => 'true',
            'response' => ['email'          => $email,
                           'RemainingPoint' => $remainingPoint,
                           'Accomplishment' =>
                               ['FindLittleMan'    => ($FindLittleMan) ?
                                   'true' : 'false',
                                'YouAreFilthyRich' => ($YouAreFilthyRich) ?
                                    'true' : 'false']
            ]];

    }

}
