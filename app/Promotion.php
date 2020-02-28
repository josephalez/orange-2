<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = [
        'id',
        'plan', 
        'equipment', 
        'activation_price',
        'prepaid_price', 
        'trash', 
        'active'
    ]; 

    public static function createPromotion($request){
        $keysAllow = [
            'id',
            'plan', 
            'equipment', 
            'activation_price',
            'prepaid_price', 
            'active'
        ];
        
        $itemToSave = [];
        
        foreach ($keysAllow as $key)
            if (isset($request[$key])) $itemToSave[$key] = $request[$key];

        return Promotion::create($itemToSave);
    }

    public static function getAll(){
        $query = DB::table('promotions')->select('*')->where('trash','=',0)->where("active","=",1);
        //Tambien trae los inactivos por que en el frontend se ve si estan activos o no
        return $query->get();
    }

    public static function createPlan($request){
        $keysAllow = [
            'id',
            'plan', 
            'equipment', 
            'activation_price',
            'prepaid_price', 
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
    

    public static function editPromotion($request, $id){
        $promotion = Promotion::find($id);

        $keysAllow = [
            'id',
            'plan', 
            'equipment', 
            'activation_price',
            'prepaid_price', 
            'active'
        ];
        
        $keysBoolean = ['active'];
        foreach ($keysBoolean as $key)
            if (isset($request[$key]) && $request[$key] !== null)
                if (is_string($request[$key]))
                    $request[$key] = ($request[$key] == '1' || $request[$key] == 'true') ? 1 : 0;
  
        foreach ($keysAllow as $key)
            if (isset($request[$key])) 
                $promotion->{$key} = $request[$key];

        if(!$promotion->save()) return false;
        return true;
    }
    
    
    public static function showAll(){
        $query = DB::table('promotions');
        return $query->get();
    }
}
