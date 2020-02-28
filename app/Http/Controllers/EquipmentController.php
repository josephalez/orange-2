<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Helpers\MPage;

class EquipmentController extends Controller
{
    public static function store(Request $request){

        $requestArray = $request->all();
        $requestArray['details'] = json_decode($requestArray['details']);

        $validator = Validator::make($requestArray, [
            'code'                  => 'required|string|unique:equipments|min:2|max:32',//sobran 16
            'name'                  => 'required|string|min:2|max:32',
            'description'           => 'string|min:6|max:190',
            'mark'                  => 'string|min:2|max:24',
            'image'                 => 'file|mimes:jpg,jpeg,png,bmp|max:5242880', //5 MB
            'price'                 => 'numeric|between:-99999999.99,+99999999.99',
            'details.storage'       => 'numeric',
            'details.camera'        => 'numeric',
            'details.screen.width'  => 'numeric',
            'details.screen.height' => 'numeric',
            'active'                => 'boolean',
            'exception'             => 'boolean',
            'is_html'               => 'boolean'

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();

        if ($request->hasFile('image')) {
            $file=$request->file("image");

            $mime = $file->getMimeType();

            //Para que la imagen no tenga el nombre repetido
            $filename = 'img_'.uniqid().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/devices'), $filename);

            $_request['image'] = 'uploads/devices/'.$filename;
        }

        $equipment = Equipment::createEquipment($_request);
        if(!$equipment) return response()->json('Database Error',500);
        return response()->json('Equipment Succesfully Created',200);
    }

    public function update(Request $request, $id){

        $requestArray = $request->all();
        $requestArray['details'] = json_decode($requestArray['details']);

        //Validar "No puedes editar un equipo que ha sido eliminado".
        $validator = Validator::make($requestArray, [
            'code'                  => 'required|string|min:2|max:32',//sobran 16
            'name'                  => 'required|string|min:2|max:32',
            'description'           => 'string|min:6|max:190',
            'mark'                  => 'string|min:2|max:24',
            'image'                 => 'file|mimes:jpg,jpeg,png,bmp|max:5242880', //5 MB
            'price'                 => 'numeric|between:-99999999.99,+99999999.99',
            'details.storage'       => 'numeric',
            'details.camera'        => 'numeric',
            'details.screen.width'  => 'numeric',
            'details.screen.height' => 'numeric',
            'active'                => 'boolean',
            'exception'             => 'boolean',
            'is_html'               => 'boolean'
        ]);

        //var_dump($requestArray["details"]); exit();

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $_request = $request->all();

        if ($request->hasFile('image')) {
            $file=$request->file("image");

            $mime = $file->getMimeType();

            //Para que la imagen no tenga el nombre repetido
            $filename = 'img_'.uniqid().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/devices'), $filename);

            $_request['image'] = 'uploads/devices/'.$filename;

        }

        if(isset($requestArray["code"])){
            $byCode=DB::table("equipments")->where("code","=",$requestArray["code"])->first();
            if($byCode)
                if($byCode->id!=$id) return response()->json("El codigo no corresponde a este dispositivo",403);
        }
        $_request['id'] = $id;
        $equipment = Equipment::editEquipment($_request,$id);
        if(!$equipment) return response()->json('Malo mano',200);
        return response()->json('Fino mano',200);
    }

    public function getAll(Request $request){
        $equipments = Equipment::getAll();
        return $equipments;
    }

    public function find($id){
        $equipment = DB::table('equipments')->where("equipments.id", $id)
        ->leftjoin('stocks', 'stocks.equipment', '=', 'equipments.id')
        ->select('equipments.*', DB::raw('count(CASE WHEN stocks.trash=0 or stocks.line=null THEN 1 ELSE NULL END) as stockCount'))
        ->groupBy('equipments.id')->first();
        $equipment->details = json_decode($equipment->details);
        return response()->json($equipment, 200);
    }

    public function paginate(Request $request){

        $pquery = DB::table('equipments')->where('equipments.trash', 0)
        ->leftjoin('stocks', 'stocks.equipment', '=', 'equipments.id')
        ->select('equipments.*', DB::raw('count(CASE WHEN stocks.trash=0 or stocks.line=null THEN 1 ELSE NULL END) as stockCount'))
        ->groupBy('equipments.id');

        if($request->input("orderby_stockCount")){
            $pquery->orderBy(DB::raw('count(CASE WHEN stocks.trash=0 or stocks.line=null THEN 1 ELSE NULL END)'),
                 (strtoupper($request->input('orderby_stockCount')) == 'ASC') ? 'ASC' : 'DESC');
        }


        $equipments = null;

        try {
            $equipments = MPage::paginate($pquery, $request, 12, '', 'equipments');
        } catch(\Exception $e) {
            return response()->json('Error al obtener datos', 500);
        }

        foreach ($equipments['items'] as $equipment) {
          if ($equipment->details && isset($equipment->details))
            $equipment->details = json_decode($equipment->details);
            if (is_string($equipment->details))
              $equipment->details = json_decode($equipment->details);
        }

        return $equipments;
    }

    public function destroy($id, Request $request){
        $equipment = Equipment::find($id);
        if (!$equipment) return response()->json(['No se encontro el equipo'],404);

        $equipment->code = $equipment->code.'_d_'.uniqid(); //13 + 3 caracteres
        $equipment->trash = 1;
        $equipment->save();
        return response()->json(['Eliminado con exito'],200);

    }


}
