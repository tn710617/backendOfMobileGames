<?php
namespace App\Http\Controllers;

use App\Helpers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ApiLoginController extends Controller
{
    public function login (Request $request)
    {
        $toBeValidated = [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ];
        if ($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage);
        }

        if (!auth::attempt(request(['email', 'password'])))
        {
            return Helpers::result(false, 'Please check your credentials again');
        }

        $token = Helpers::uniqueTokenCreator();

        User::where('email', $request->email)->update([
            'api_token' => $token,
            'expiry_time' => time() + 86400,
        ]);

        return Helpers::result(true, $token);
    }

}
