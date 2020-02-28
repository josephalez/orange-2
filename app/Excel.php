<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Excel extends Model
{
    protected $fillable = [
        'id',
        'originalName',
        'file',
        'details'
    ];

    public static function createExcel($data){
        return Excel::create($data);
    }

    public static function getAll(){
        $query = DB::table('excels');
        return $query->get();
    }
}
