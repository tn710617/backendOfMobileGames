<?php

namespace App\Http\Middleware;

use App\Helpers;
use App\User;
use Closure;

class tokenValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $toBeValidated = [
            'token' => 'required'
        ];
        if ($failMessage = Helpers::validation($toBeValidated, $request))
        {
            return Helpers::result(false, $failMessage);
        }
        $receivedToken = $request->token;
        $whetherTokenExists = User::where('api_token', $receivedToken)->count();

        if ($whetherTokenExists)
        {
            $currentExpiryTime = User::where('api_token', $receivedToken)->first()->expiry_time;
            if ($currentExpiryTime > time())
            {
                User::where('api_token', $receivedToken)->update(['expiry_time' => time() + 86400]);
            }
            return $next($request);
        }

        else return response(['result' => 'false', 'response' => 'Please login before further proceeding']);
    }
}
