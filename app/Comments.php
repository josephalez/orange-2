<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comments extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'id',
        'content',
        "image",
        'sell',
        'user'
    ];

    public static function getAll($sell){
        $query = DB::table('comments')->select('*')->where('sell','=',$sell);
        //Tambien trae los inactivos por que en el frontend se ve si estan activos o no
      if(!empty($query)) $data = array_map(function($comment){
        return $comment;
      },$query->get()->toArray());
      return $data;
    }


    public static function createComment($request){
        $keysAllow = [
            'id',
            "image",
            'content',
            'sell',
            'user'
        ];

        $itemToSave = [];

        foreach ($keysAllow as $key)
            if (isset($request[$key])) $itemToSave[$key] = $request[$key];

        return comments::create($itemToSave);
    }
}
