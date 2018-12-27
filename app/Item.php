<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
