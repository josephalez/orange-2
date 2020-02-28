<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Commune extends Model
{
  public static function get(){
    $query = DB::table('communes');
    return $query->get();
  }
}
