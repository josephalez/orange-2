<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Client extends Model{

  protected $fillable = [
    'rut',
    'name',
    'last_name',
    'last_name_2',
    'phone',
    'address',
    'carnet',
    'birthday',
    'carnet_expiration',
    'type',
    'comuna',
    'class',
    'email'
  ];

    public static function getPuntosRut( $rut , $noK = false ){
      $rut = str_replace('.','',$rut);//borro los puntos en caso de tenerlos
      $rutTmp = explode( "-", $rut );
      //En caso de no haber enviado ultimo digito o no conocerlo, se sustituye por K (o 0)
      $kDigit = (isset($rutTmp[1])) ? $rutTmp[1] : 'K';

      //var_dump($rutTmp[0]);exit();

      if (is_numeric($rutTmp[0])) {
        $toReturn = number_format($rutTmp[0], 0, "", ".") . '-' . $kDigit;

        if ($noK) $toReturn = number_format($rutTmp[0], 0, "", ".");
      }else{
        $toReturn = $rutTmp[0] . '-' . $kDigit;

        if ($noK) $toReturn = $rutTmp[0];
      }

      return $toReturn;
    }

    public static function createClient($request){

        $keysAllow = [
          'rut',
          'name',
          'last_name',
          'last_name_2',
          'phone',
          'address',
          'carnet',
          'birthday',
          'carnet_expiration',
          'type',
          'comuna',
          'class',
          'email'
        ];

        $itemToSave = [];

        foreach ($keysAllow as $key)
          if (isset($request[$key])) $itemToSave[$key] = $request[$key]; else $itemToSave[$key] = null;

        $itemToSave['rut'] = Client::getPuntosRut($itemToSave['rut']);

        return Client::create($itemToSave);
    }

    public static function getActiveSell($id) {
      /*//Una forma...
        $client = Client::find($id);
        $sells = $client->sells;
        foreach ($sells as $sell)
          foreach ($sell->lines as $line) {
            $lineState = $line->subestado->estado;
            if ($lineState->id != 8 && $lineState->id != 9)
              $active_sell = $sell;
          }*/

      //Forma elegante
      return DB::table('clients')
      ->join('sales','sales.client','=','clients.id')
      ->join('lines','lines.sale','=','sales.id')
      ->join('substates','lines.substate','=','substates.id')
      ->join('states','substates.state','=','states.id')
      ->select(
        'sales.*','lines.*','substates.*','states.*',
        'substates.name as subestado','states.name as estado'
      )
      ->where('states.id','<>',8)//Terminada
      ->where('states.id','<>',9)//Cancelada
      ->where('clients.id','=',$id)
      ->first();
    }

    public static function updateClient($request, $id){

        $keysAllow = [
          'rut',
          'name',
          'last_name',
          'last_name_2',
          'phone',
          'address',
          'carnet',
          'birthday',
          'carnet_expiration',
          'type',
          'comuna',
          'class',
          'email'
        ];

        $client = Client::find($id);
        foreach ($keysAllow as $key)
          if (isset($request[$key])) $client->$key = $request[$key];
        $client->save();
        return $client;
    }

    public function sells(){
      //belongsToMany es varios y varios
      return $this->hasMany('App\Sale', 'client', 'id');
    }



}
