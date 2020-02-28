<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Region extends Model
{
    public static function get(){
      $query = DB::table('regions');
      return $query->get();
    }
}
