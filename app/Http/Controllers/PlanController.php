<?php

namespace App\Http\Controllers;

use App\Helpers\MPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Plan;

class PlanController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|unique:Plans|string|min:2|max:32',
            'price'           => 'numeric|between:-99999999.99,+99999999.99',
            'activation_price'=> 'numeric|between:-99999999.99,+99999999.99',
            'points'          => 'integer|between:-9999999999,+999999999',
            'active'          => 'boolean'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();

        $Plan = Plan::createPlan($_request);
        if(!$Plan) return response()->json('Database Error',500);
        return response()->json('Plan creado con éxito',200);
    }

    public function getAll(Request $request){
        $Plans = Plan::getAll();
        return $Plans;
    }

    public function paginate(Request $request){

        $pquery = DB::table('plans')->where('trash','=',0);
        $Plan = null;

        try {
            $Plan = MPage::paginate($pquery, $request);
        } catch (\Exception $e) {
          //return response()->json('Error al obtener datos', 500); //<-- production
            return response()->json($e, 500);
        }

        return $Plan;
    }

    public function find($id){
        $Plan = Plan::find($id);
        return response()->json($Plan, 200);
    }

    public function update(Request $request, $id){
        $requestArray = $request->all();
        $validator = Validator::make($requestArray, [
            'name'            => 'required|string|min:2|max:32',
            'price'           => 'numeric|between:-999999999.99,+999999999.99',
            'activation_price'=> 'numeric|between:-999999999.99,+999999999.99',
            'points'          => 'integer|between:-9999999999,+999999999',
            'active'          => 'boolean'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();

        if(isset($_request["name"])){
            $byName=DB::table("plans")->where("name","=",$_request["name"])->first();
            if($byName)
                if($byName->id!=$id) return response()->json("El nombre ya existe",403);
        }

        $_request['id'] = $id;
        $Plan = Plan::editPlan($_request, $id);
        if(!$Plan) return response()->json('Error en la Base de datos',500);
        return response()->json('Editado con exito',200);
    }

    public function destroy($id, Request $request){
        $Plan = Plan::find($id);
        if (!$Plan) return response()->json(['No se encontro plan'],404);
        $Plan->name = $Plan->name.'_d_'.uniqid(); //13 + 3 caracteres
        $Plan->trash = 1;
        $Plan->save();
        return response()->json(['Eliminado con exito'],200);
    }
}
