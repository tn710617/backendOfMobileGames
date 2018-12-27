<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Type extends Model {

    public static function getType($model, Request $request)
    {
        $id = substr(strtolower(get_class($model)) . '_id', 4);

        return $model->find($request->$id)->type->name;
    }

}
