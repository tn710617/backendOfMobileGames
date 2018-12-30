<?php

namespace App\Http\Controllers;

use App\Achieved;
use App\Helpers;
use App\Purchased;
use App\User;
use Illuminate\Http\Request;

class ApiSessionsController extends Controller {

    public function show(Request $request)
    {
        $user = (new User())->find(User::getUserId($request->token));
        $remainingPoints = $user->remainingPoints;
        $email = $user->email;
        $achievedAchievement = Achieved::getAchieved($request);
        $possessions = Purchased::getPossessedItems($request);
        $response = ['email'               => $email,
                     'remainingPoints'     => $remainingPoints,
                     'achievedAchievement' => $achievedAchievement,
                     'possessions'         => $possessions,
        ];

        return Helpers::result(true, $response);












//        $user = new User;
//        $user = $user->where('api_token', $request->token)->first();
//        $user_id = $user->id;
//        $email = $user->email;
//        $remainingPoint = $user->RemainingPoints;
//        $FindLittleMan = MutualAccomplishment::whetherAccomplishmentAchieved($user_id, 'FindLittleMan');
//        $YouAreFilthyRich = MutualAccomplishment::whetherAccomplishmentAchieved($user_id, 'YouAreFilthyRich');
//        $YouAreSoFast = EscapeRoom::where('user_id', $user_id)->first()->YouAreSoFast;
//        $APerfectScore = GifStop::where('user_id', $user_id)->first()->APerfectScore;
//        $LuckyYou = LoveLetterGenerator::where('user_id', $user_id)->first()->LuckyYou;
//        $WhetherPurchasedItemExists = Possession::where('user_id', $user_id)->get();
//        $PurchasedItems = [];
//        foreach ($WhetherPurchasedItemExists as $whetherPurchasedItemExist)
//        {
//            $PurchasedItems[] = $whetherPurchasedItemExist->item;
//        }
//        switch ($request->game)
//        {
//            case 'escapeRoom':
//
//                return [
//                    'result'   => 'true',
//                    'response' => ['email'          => $email,
//                                   'RemainingPoint' => $remainingPoint,
//                                   'Accomplishment' =>
//                                       ['FindLittleMan'    => ($FindLittleMan) ?
//                                           'true' : 'false',
//                                        'YouAreFilthyRich' => ($YouAreFilthyRich) ?
//                                            'true' : 'false',
//                                        'YouAreSoFast'     => ($YouAreSoFast) ?
//                                            'true' : 'false',
//                                       ],
//                                   'PurchasedItems' => ($PurchasedItems) ?
//                                       $PurchasedItems : 'false'
//
//                    ]];
//
//                break;
//
//            case 'loveLetterGenerator':
//
//                return [
//                    'result'   => 'true',
//                    'response' => ['email'          => $email,
//                                   'RemainingPoint' => $remainingPoint,
//                                   'Accomplishment' =>
//                                       ['FindLittleMan'    => ($FindLittleMan) ?
//                                           'true' : 'false',
//                                        'YouAreFilthyRich' => ($YouAreFilthyRich) ?
//                                            'true' : 'false',
//                                        'LuckyYou'         => ($LuckyYou) ?
//                                            'true' : 'false',
//                                       ],
//                                   'PurchasedItems' => ($PurchasedItems) ?
//                                       $PurchasedItems : 'false'
//                    ]];
//
//                break;
//
//            case 'gifStop':
//
//                return [
//                    'result'   => 'true',
//                    'response' => ['email'          => $email,
//                                   'RemainingPoint' => $remainingPoint,
//                                   'Accomplishment' =>
//                                       ['FindLittleMan'    => ($FindLittleMan) ?
//                                           'true' : 'false',
//                                        'YouAreFilthyRich' => ($YouAreFilthyRich) ?
//                                            'true' : 'false',
//                                        'APerfectScore'    => ($APerfectScore) ?
//                                            'true' : 'false',
//                                       ],
//                                   'PurchasedItems' => ($PurchasedItems) ?
//                                       $PurchasedItems : 'false'
//                    ]];
//
//                break;
//        }

    }

}
