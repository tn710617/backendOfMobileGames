<?php

namespace App\Http\Controllers;

use App\EscapeRoom;
use App\GifStop;
use App\LoveLetterGenerator;
use App\MutualAccomplishment;
use App\User;
use Illuminate\Http\Request;

class MutualAccomplishmentController extends Controller {

    public function findTheLittleMan(Request $request)
    {
        $user_id = User::where('api_token', $request->token)->first()->id;

        switch ($request->game)
        {
            case 'escapeRoom':
                $numberOfFindingLittleMan = EscapeRoom::where('user_id', $user_id)->first()->FindLittleMan;
                EscapeRoom::where('user_id', $user_id)->update(['FindLittleMan' => ($numberOfFindingLittleMan + 1)]);

                if (MutualAccomplishment::getTotalNumberOfFindingLittleMan($request) >= 20)
                {
                    MutualAccomplishment::where('user_id', $user_id)->update(['FindLittleMan' => 1]);

                    return ["result"           => "true",
                            "response"         => "You've successfully updated",
                            "findTheLittleMan" => "Congratulations! You've discovered the little man for 20 times"
                    ];
                } else
                    return ["result"   => "true",
                            "response" => "You've successfully updated"];

                break;
            case 'loveLetterGenerator':

                $numberOfFindingLittleMan = LoveLetterGenerator::where('user_id', $user_id)->first()->FindLittleMan;
                LoveLetterGenerator::where('user_id', $user_id)->update(['FindLittleMan' => $numberOfFindingLittleMan + 1]);

                if (MutualAccomplishment::getTotalNumberOfFindingLittleMan($request) >= 20)
                {
                    MutualAccomplishment::where('user_id', $user_id)->update(['FindLittleMan' => 1]);

                    return ["result"           => "true",
                            "response"         => "You've successfully updated",
                            "findTheLittleMan" => "Congratulations! You've discovered the little man for 20 times"
                    ];
                } else
                    return ["result"   => "true",
                            "response" => "You've successfully updated"];

                break;

            case 'gifStop':
                $numberOfFindingLittleMan = GifStop::where('user_id', $user_id)->first()->FindLittleMan;
                GifStop::where('user_id', $user_id)->update(['FindLittleMan' => $numberOfFindingLittleMan + 1]);

                if (MutualAccomplishment::getTotalNumberOfFindingLittleMan($request) >= 20)
                {
                    MutualAccomplishment::where('user_id', $user_id)->update(['FindLittleMan' => 1]);

                    return ["result"           => "true",
                            "response"         => "You've successfully updated",
                            "findTheLittleMan" => "Congratulations! You've discovered the little man for 20 times"
                    ];
                } else
                    return ["result"   => "true",
                            "response" => "You've successfully updated"];

                break;
        }
    }

    public function personalAccomplishment(Request $request)
    {
        $user_id = User::where('api_token', $request->token)->first()->id;
        switch ($request->game)
        {
            case 'escapeRoom':
                EscapeRoom::where('user_id', $user_id)->update(['YouAreSoFast' => 1]);

                return ['result' => 'true', 'response' => "You've achieved $request->accomplishment"];

                break;

            case 'loveLetterGenerator':
                LoveLetterGenerator::where('user_id', $user_id)->update(['LuckyYou' => 1]);

                return ['result' => 'true', 'response' => "You've achieved $request->accomplishment"];

                break;

            case 'gifStop':
                GifStop::where('user_id', $user_id)->update(['APerfectScore' => 1]);

                return ['result' => 'true', 'response' => "You've achieved $request->accomplishment"];

                break;
        }
    }


}
