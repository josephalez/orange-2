<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class plan extends Model
{
    protected $table = 'plans';

    protected $fillable = [
        'id',
        'name',
        'price',
        'activation_price',
        'points',
        'trash',
        'active'
    ];

    public static function getAll(){
        $query = DB::table('plans')->select('*')->where('trash','=',0);
        //Tambien trae los inactivos por que en el frontend se ve si estan activos o no
      if(!empty($query)) $data = array_map(function($plan){
        return $plan;
      },$query->get()->toArray());
      return $data;
    }

    public static function createPlan($request){
        $keysAllow = [
            'id',
            'name',
            'price',
            'activation_price',
            'points',
            //'trash',
            'active'
        ];

        $itemToSave = [];

        $keysBoolean = ['active'];
        foreach ($keysBoolean as $key)
            if (isset($request[$key]) && $request[$key] !== null)
                if (is_string($request[$key]))
                    $request[$key] = ($request[$key] == '1' || $request[$key] == 'true') ? 1 : 0;

        foreach ($keysAllow as $key)
            if (isset($request[$key])) $itemToSave[$key] = $request[$key];

        return plan::create($itemToSave);
    }

    public static function editPlan($request, $id){
        $plan = Plan::find($id);

        $keysAllow = [
            'id',
            'name',
            'price',
            'activation_price',
            'points',
            //'trash',
            'active'
        ];
 
        $keysBoolean = ['active'];
        foreach ($keysBoolean as $key)
            if (isset($request[$key]) && $request[$key] !== null){
                if (is_string($request[$key]))
                    $request[$key] = ($request[$key] == '1' || $request[$key] == 'true') ? 1 : 0;
            }
            else
                $request[$key] = 0;


        foreach ($keysAllow as $key)
            if (isset($request[$key]))
                $plan->{$key} = $request[$key];

        if(!$plan->save()) return false;
        return true;
    }

    public static function showAll(){
        $query = DB::table('equipaments');
        return $query->get();
    }
}
