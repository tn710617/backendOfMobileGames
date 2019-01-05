<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Type extends Model {

    public static function getType(Model $binding)
    {
         return $binding->type->name;
    }

}
