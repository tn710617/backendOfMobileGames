<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function validation (Array $toBeValidated, Request $request)
    {
        $validator = validator::make($request->all(), $toBeValidated);
        if ($validator->fails())
        {
            return $validator->errors()->first();
        }
    }

    public static function uniqueTokenCreator ()
    {
        $checkIfTokenExists = 1;
        while($checkIfTokenExists)
        {
            $uniqueToken = str_random(60);
            $checkIfTokenExists = User::where('api_token', $uniqueToken)->count();
        }
        return $uniqueToken;
    }

    public static function getTotalRemainingPoints ($user_id)
    {
        return User::where('id', $user_id)->first()->RemainingPoints;
    }

    public static function getUserId ($token)
    {
        return User::where('api_token', $token)->first()->id;
    }

    public static function result ($result, $response)
    {
        return ['result' => $result, 'response' => $response];
    }

}
