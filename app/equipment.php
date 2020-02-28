<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Stock;
use App\Line;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'id',
        'code',
        'name',
        'description',
        'image',
        'description_html',
        'mark',
        'price',
        'details',
        'trash',
        'active',
        'exception',
        'is_html'
    ];

    public static function getAll(){
        $query = DB::table('equipments')->where('equipments.trash', 0)
        ->leftjoin('stocks', 'stocks.equipment', '=', 'equipments.id')
        ->select('equipments.*', DB::raw('count(CASE WHEN stocks.trash=0 or stocks.line=null THEN 1 ELSE NULL END) as stockCount'))
        ->groupBy('equipments.id');
        if(!empty($query)) $data = array_map(function($equipment){
          return [
            "created_at" => $equipment->created_at,
            "updated_at" => $equipment->updated_at,
            "name" => $equipment->name,
            "image" => $equipment->image,
            "exception" => $equipment->exception,
            "id" => $equipment->id,
            "trash" => $equipment->trash,
            "active" => $equipment->active,
            "stockCount" => $equipment->stockCount,
          ];
        },$query->get()->toArray());
        return $data;
      }

      public function getStockAttribute() {
        $stockCount = 0;
        $stockCount = Stock::where('equipment',$this->id)->where('trash',0)->where('lost',0)->where('line',null)->count();
        return $stockCount;
      }

      /*public function getReallyStockAttribute() {
        $stockCount = 0;
        $deviceID = $this->id;

        $stockCount = Stock::where('stocks.trash',0)//El stock no este eliminado
        ->leftjoin('lines','lines.equipment','=','stocks.equipment') //Yo busco varios cosos
        ->where('stocks.equipment',$deviceID)
        //->where('lines.equipment',$deviceID) Redundante
        ->where(function($query) {
          $query->where('stocks.line',null)
        })
        ->orWhere(function($query) {
          //Em caso de que este nula pero....

        })


        ->join('substates','lines.substate','=','substates.id')
        ->join('states','substates.state','=','states.id')
        ->select(
          'sales.*','lines.*','substates.*','states.*',
          'substates.name as subestado','states.name as estado'
        )
        ->count();
        return $stockCount;
      }*/

      public function getConjuntoDAttribute(){
        $stockCount = 0;
        $stockCount = Line::where('lines.equipment',$this->id)
        ->distinct('lines.id')
        ->leftJoin('stocks', function($join) {
                            $join->on('lines.id', '=', 'stocks.line');
                            //$join->on('stocks.equipment','=','lines.equipment');
        })
        ->leftjoin('substates','lines.substate','=','substates.id')
        ->leftjoin('states','substates.state','=','states.id')
        ->where('lines.canceled',0)
        //->select('lines.substate','lines.equipment as EquipoID','lines.id as LineID','states.name as Estado','substates.name as SubEstado','stocks.id as STOCKID')
        ->whereRaw('stocks.line IS NULL')
        ->where('states.id','<>',8)
        ->where('states.id','<>',9)
        ->count();
        return $stockCount;
      }

      public function getReallyStockAttribute() {
        //U: UNIVERSO -> Stock, Lineas asociados a un equipo X
        //A = Conjunto del stock asociado a un equipo X
        //B = Conjunto de las lineas asociado a un equipo X
        //C = Sub conjunto de las lineas que estan activas (B n C = C) asociado a un equipo X
        //A - B = (STOCK DISPONIBLE) conjunto de stock el cual no tiene asignado una linea
        //B n C = (C) conjunto de aquellas lineas creadas que esten activas (line.canceled = 0 && Estado <> 'TERMINADO' && Estado <> 'CANCELADO' )
        //( B n C ) - A ---> (D) conjunto de aquellas lineas que esten activas que NO esten asociadas a un stock
        //Verdadero STOCK disponible = | A - B | - | ( B n C ) - A |
        //var_dump($this->stock); | A - B |
        //var_dump($this->conjunto_d); | D | = | ( B n C ) - A |
        //exit();
        //var_dump($this->stock - $this->conjuntoD);exit();
        return $this->stock - $this->conjuntoD;
      }

      public static function createEquipment($request){

        if (isset($request['details']))
            $request['details'] = json_encode($request['details']);
        else
            $request['details'] = json_encode([
                'camera' => 0,
                'screen' => [
                    'height' => 0,
                    'width' => 0,
                ],
                'storage' => 0
            ]);

        $keysAllow = [
            'code',
            'name',
            'description',
            'description_html',
            'mark',
            'image',
            'price',
            'details',
            'active',
            'exception',
            'is_html'
        ];

        $itemToSave = [];

        $keysBoolean = ['active','is_html','exception'];
        foreach ($keysBoolean as $key)
            if (isset($request[$key]) && $request[$key] !== null)
                if (is_string($request[$key]))
                    $request[$key] = ($request[$key] == '1' || $request[$key] == 'true') ? 1 : 0;

        foreach ($keysAllow as $key)
            if (isset($request[$key])) $itemToSave[$key] = $request[$key];

        return Equipment::create($itemToSave);
    }
    public static function editEquipment($request, $id){

        if (isset($request['details']))
            $request['details'] = json_encode($request['details']);

        $device = Equipment::find($id);

        $keysAllow = [
            'code',
            'name',
            'description',
            'description_html',
            'mark',
            'image',
            'price',
            'details',
            'active',
            'exception',
            'is_html'
        ];

        $keysBoolean = ['active','is_html','exception'];
        foreach ($keysBoolean as $key)
            if (isset($request[$key]) && $request[$key] !== null){
                if (is_string($request[$key]))
                    $request[$key] = ($request[$key] == '1' || $request[$key] == 'true') ? 1 : 0;
            }
            else
                $request[$key] = 0;


        foreach ($keysAllow as $key)
            if (isset($request[$key]))
                $device->{$key} = $request[$key];

        if(!$device->save()) return false;
        return true;
    }
    public static function showAll(){
        $query = DB::table('equipments');
        return $query->get();
    }
}
