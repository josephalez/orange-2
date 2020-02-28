<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Substate extends Model
{
  public function estado(){
    //return $this->hasMany('App\Substate', 'id', 'substate');
    return $this->belongsTo('App\State', 'state', 'id');
  }
}
