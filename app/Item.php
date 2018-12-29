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

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public static function getItemName($item_id)
    {
        return Item::find($item_id)->name;
    }


    public static function getItemCost($item_id)
    {
        return Item::find($item_id)->cost;
    }

    public static function getGameName($item_id)
    {
        return Item::find($item_id)->game->name;
    }
}
