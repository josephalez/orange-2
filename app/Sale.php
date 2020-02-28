<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Client;
use App\Line;
use App\History;
use App\State;
use App\Substate;
use Carbon\Carbon;
use Auth;

class Sale extends Model
{

  protected $fillable = [
      'observation',
      'client',
      'seller',
      'supervisor',
      'analyst',
      'biker',
      'delivery_address',
      'delivery_region',
      'delivery_commune',
      'delivery_phone',
      'delivery_initial_time',
      'delivery_final_time',
      'delivery_geographic_location',
      'delivery_observation',
      'chip_price',
      'delivery_price',
      'activation_price',
      'claro_debt',
      'agreement_footer',
      'advance_charge',
      'total',
      'other_data',
      'metadata',
      'substate'
  ];

  public static function FormatingRequest($request) {
    //Formateando en caso de...:
    if (!isset($request['delivery_geographic_location']))
      $request['delivery_geographic_location'] = json_encode(['lat' => null,'lng' => null]);

    //Fusionando...

    if (isset($request['delivery_date'])){

      /*Fusion de fechas -> Buen trabajo!*/
      if (isset($request['delivery_initial_time'])){
        $request['delivery_initial_time'] = $request['delivery_date'] . ' ' . $request['delivery_initial_time'];
      }

      if (isset($request['delivery_final_time'])){
        $request['delivery_final_time'] = $request['delivery_date'] . ' ' . $request['delivery_final_time'];
      }
    }

    return $request;
  }

  public static function createSale($request, $sendSupervisor = false){

    $request = Sale::FormatingRequest($request);

    $client = DB::table('clients')->where('rut', $request['rut'])->first();
    if(!$client) $client = Client::createClient($request);

    $ClientId = $client->id;
    $client = Client::updateClient($request, $ClientId);


      $keysAllow = [
        'observation',
        //'client',
        'seller',
        'supervisor',
        'analyst',
        'biker',
        'delivery_address',
        'delivery_region',
        'delivery_commune',
        'delivery_phone',
        'delivery_initial_time',
        'delivery_final_time',
        'delivery_geographic_location',
        'delivery_observation',
        'chip_price',
        'delivery_price',
        'activation_price',
        'claro_debt',
        'agreement_footer',
        'advance_charge',
        'total',
        'other_data',
        'metadata'
      ];

      $itemToSave = [];

      foreach ($keysAllow as $key)
        if (isset($request[$key])) $itemToSave[$key] = $request[$key];


      $itemToSave['client'] = $ClientId;


      $sale = Sale::create($itemToSave);
      if (!$sale) return response()->json('Database Error', 500);

      $sale = DB::table('sales')->latest('created_at')->first();
      $sale = $sale->id;//hay mejores maneras de hacer esto.... but aja xd

      if (isset($request['lines'])) {
        if (is_string($request['lines'])) $request['lines'] = json_decode($request['lines']);

        $lines = $request['lines'];

        foreach ($lines as $line => $value) {
          Line::createLine($value, $sale);
          /*if ($request['send']){
            $newline = DB::table('lines')->latest('created_at')->first();
            $newline = Line::find($newline->id);
            $newline->executive_send = Carbon::now();
            $newline->substate = 3;
            $newline->save();
          }*/
        }

      }


      History::Entry($sale, 'Creacion de venta', ''.Auth::user()->name.' ha creado la venta #'.$sale.'.', 'fa fa-star', []);

      if ($sendSupervisor) {
        Sale::changeSubState($sale,3,true,true,true);
        History::Entry($sale, 'Envio al supervisor', Auth::user()->name.' ha enviado la venta #'.$sale.' al supervisor, ahora se encuentra en REVISION', 'fa fa-exchange', ['supervisor' => Auth::user()->name.' te ha enviado la venta #'.$sale]);
      }

      return true;
  }

  public static function updateSale($request, $id){

      $request = Sale::FormatingRequest($request);

      $keysAllow = [
        'observation',
        /*'seller',
        'supervisor',
        'analyst',*/
        //'biker',
        'delivery_address',
        'delivery_region',
        'delivery_commune',
        'delivery_phone',
        'delivery_initial_time',
        'delivery_final_time',
        'delivery_geographic_location',
        'delivery_observation',
        'chip_price',
        'delivery_price',
        'activation_price',
        'claro_debt',
        'agreement_footer',
        'advance_charge',
        'total',
        'other_data',
        'metadata'
      ];

      $sale = Sale::find($id);
      foreach ($keysAllow as $key)
        if (isset($request[$key])) $sale->$key = $request[$key];
      $sale->save();

      if (isset($request['lines'])){
        $lines = $request['lines'];

        foreach ($lines as $line) {

          //var_dump($value->id);
          if (!isset($line->id) || !$line->id){
            Line::createLine($line, $id);
          }else {
            Line::updateLine($line);
          }

        }
      }

      History::Entry($id, 'Edicion de venta', ''.Auth::user()->nombre.' ha editado la venta #'.$id.'.', 'fa fa-pencil', []);

      return $sale;
  }

  public static function getLines($id){
      $sale = Sale::find($id);
      return $sale->lines;
  }
  /*what?*/
  public function lines(){
    return $this->hasMany('App\Line', 'sale', 'id');
  }

  //-----------
  public function haveSubstate($substate){
    foreach ($this->lines as $lineKey => $line)
      if (!$line->canceled && $line->subestado->id == $substate) return true;

    return false;
  }
  public function haveState($state){
    foreach ($this->lines as $lineKey => $line)
      if (!$line->canceled && $line->subestado->estado->id == $state) return true;

    return false;
  }
  //-----------

  public static function changeSubState($sale, $substate, $specify = true, $ignore = true, $onlyForState = null) {

    $sale = Sale::find($sale); if (!$sale) return false;

    $subState = Substate::find($substate);
    if (!$subState) return false;

    $state = State::find($subState->state);
    if (!$state) return false;

    $stateOfOnly = null;
    if ($onlyForState) {
      $stateOfOnly = State::find($onlyForState);
      if (!$stateOfOnly) return false;//el "onlyforstate" no fue encontrado
    }

    foreach ($sale->lines as $key => $value) {
      //var_dump($value->subestado->estado);exit();
      if (!$value->canceled && $value->subestado->estado->id != 8 && $value->subestado->estado->id != 9){

        /*
          Si el estado de la linea no es mi "estado a cambiar" teniendo un
          "solo para el estado...", paso a la siguiente linea
        */
        //var_dump($onlyForState);exit();
        ///var_dump($value->subestado->estado->id);//exit();
        if ($onlyForState && $value->subestado->estado->id != $onlyForState) continue;
        //var_dump('oil');exit();
        //var_dump($substate);exit();
        Line::changeState($value->id, $substate, Auth::user(), $ignore, false);

      }
    }
    //var_dump('oil');exit();

    if ($specify)
      if (!$onlyForState)
        History::Entry($sale->id, 'Cambio de subestado', ''.Auth::user()->name.' ha cambiado el subestado de todas las lineas de la venta #'.$sale->id.' a '.$subState->name.' ahora se encuentra en el estado '.$state->name.'.', 'fa fa-exchange', []);
      else if ($stateOfOnly)
        History::Entry($sale->id, 'Cambio de subestado', ''.Auth::user()->name.' ha cambiado el subestado de todas las lineas de la venta #'.$sale->id.' en el estado '.$stateOfOnly->name.' al subestado '.$subState->name.' ahora se encuentran en el estado '.$state->name.'.', 'fa fa-exchange', []);

    return true;

  }

  //------

  public function comments(){
    return $this->hasMany('App\Comments', 'sell', 'id');
  }

  public function histories(){
    return $this->hasMany('App\History', 'sale', 'id')->orderBy('created_at');
  }

}
