<?php

namespace App\Http\Controllers;

use App\EscapeRoom;
use App\GifStop;
use App\LoveLetterGenerator;
use App\MutualAccomplishment;
use App\Possession;
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
        $YouAreSoFast = EscapeRoom::where('user_id', $user_id)->first()->YouAreSoFast;
        $APerfectScore = GifStop::where('user_id', $user_id)->first()->APerfectScore;
        $LuckyYou = LoveLetterGenerator::where('user_id', $user_id)->first()->LuckyYou;
        $WhetherPurchasedItemExists = Possession::where('user_id', $user_id)->get();
        $PurchasedItems = [];
        foreach ($WhetherPurchasedItemExists as $whetherPurchasedItemExist)
        {
            $PurchasedItems[] = $whetherPurchasedItemExist->item;
        }
        switch ($request->game)
        {
            case 'escapeRoom':

                return [
                    'result'   => 'true',
                    'response' => ['email'          => $email,
                                   'RemainingPoint' => $remainingPoint,
                                   'Accomplishment' =>
                                       ['FindLittleMan'    => ($FindLittleMan) ?
                                           'true' : 'false',
                                        'YouAreFilthyRich' => ($YouAreFilthyRich) ?
                                            'true' : 'false',
                                        'YouAreSoFast'     => ($YouAreSoFast) ?
                                            'true' : 'false',
                                       ],
                                    'PurchasedItems' => ($PurchasedItems) ?
                                        $PurchasedItems : 'false'

                    ]];

                break;

            case 'loveLetterGenerator':

                return [
                    'result'   => 'true',
                    'response' => ['email'          => $email,
                                   'RemainingPoint' => $remainingPoint,
                                   'Accomplishment' =>
                                       ['FindLittleMan'    => ($FindLittleMan) ?
                                           'true' : 'false',
                                        'YouAreFilthyRich' => ($YouAreFilthyRich) ?
                                            'true' : 'false',
                                        'LuckyYou'         => ($LuckyYou) ?
                                            'true' : 'false',
                                       ]
                    ]];

                break;

            case 'gifStop':

                return [
                    'result'   => 'true',
                    'response' => ['email'          => $email,
                                   'RemainingPoint' => $remainingPoint,
                                   'Accomplishment' =>
                                       ['FindLittleMan'    => ($FindLittleMan) ?
                                           'true' : 'false',
                                        'YouAreFilthyRich' => ($YouAreFilthyRich) ?
                                            'true' : 'false',
                                        'APerfectScore'    => ($APerfectScore) ?
                                            'true' : 'false',
                                       ]
                    ]];

                break;
        }

    }

}
