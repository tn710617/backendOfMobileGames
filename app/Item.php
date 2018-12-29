<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Item extends Model
{
    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public static function getItemName($item_id)
    {
        return Item::find($item_id)->name;
    }



}
