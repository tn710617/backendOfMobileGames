<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchased extends Model
{
    public function executeByType($request, $type)
    {
        switch ($type) {
            case 'one-time':

                break;

            case 'aggregatable':




                break;
        }
    }
}
