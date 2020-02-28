<?php

namespace App\Http\Controllers;

use App\Helpers\MPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Promotion;

class PromotionController extends Controller
{
    public static function store(Request $request){
        $validator = Validator::make($request->all(), [
            'plan'             => 'required|numeric|exists:plans,id',
            'equipment'        => 'required|numeric|exists:equipments,id',
            'activation_price' => 'numeric|between:-99999999.99,+99999999.99',
            'prepaid_price'    => 'numeric|between:-99999999.99,+99999999.99',
            'active'           => 'boolean'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();

        $promotion = Promotion::createPromotion($_request);
        if(!$promotion) return response()->json('Database Error',500);
        return response()->json('Promotion Succesfully Created',200);
    }
    public function getAll(Request $request){
        $promotions = Promotion::getAll();
        return $promotions;
    }

    public function paginate(Request $request){

        $pquery = DB::table('promotions')->where('promotions.trash','=',0)
        ->join('equipments', 'equipments.id', '=', 'promotions.equipment')
        ->join('plans', 'plans.id', '=', 'promotions.plan')
        ->selectRaw('promotions.*, equipments.image as equipment_image,
        plans.name as plan_name, plans.price as plan_price');
        $promotion = null;

        if($request->input("by_plan")){
            $pquery->where("plans.id","=",$request->input("by_plan"));
        }

        try {
            $promotion = MPage::paginate($pquery, $request,12,'','promotions');
        } catch (\Exception $e) {
            return response()->json('Error al obtener datos', 500);
        }

        return $promotion;
    }

    public function find($id){
        $promotion = Promotion::find($id);
        return $promotion;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'plan'             => 'required|numeric|exists:plans,id',
            'equipment'        => 'required|numeric|exists:equipments,id',
            'activation_price' => 'numeric|between:-99999999.99,+99999999.99',
            'prepaid_price'    => 'numeric|between:-99999999.99,+99999999.99',
            'active'           => 'boolean'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();
        $_request['id'] = $id;
        $promotion = Promotion::editPromotion($_request, $id);
        if(!$promotion) return response()->json('Error en la Base de datos',500);
        return response()->json('Editado con exito',200);
    }

    public function destroy($id, Request $request){
        $promotion = Promotion::find($id);
        if (!$promotion) return

        $promotion->name = $promotion->name.'_d_'.uniqid(); //13 + 3 caracteres
        $promotion->trash = 1;
        $promotion->save();
        return response()->json(['Eliminado con exito'],200);
    }
}
