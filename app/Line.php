<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Equipment;

use Auth;
use App\Sale;
use App\Stock;
use App\States;
use App\Substates;
use App\History;

class Line extends Model
{

    protected $fillable = [
      'sale',
      'type',
      'donor_company',
      'equipment',
      'plan',
      'pcs',
      'chip_price',
      'plan_cost',
      'price',
      'fees',
      'imei',
      'sim',
      'creation',
      'executive_send',
      'supervisor_send',
      'warehouse_send',
      'map_assigned_biker',
      'biker_send',
      'ok',
      'sstm',
      'finalization',
      'ambit',
      'substate'
    ];

    public static function changeState($line, $substate, $user = null, $ignore = true, $specify = false, $onlyFor = null) {
      //var_dump('oil');exit();
      $line = Line::find($line);
      if (!$line) return response()->json('Linea no encontrada', 404);

      $subState = Substate::find($substate);
      if (!$subState) return response()->json('Subestado no existe', 402);

      $state = State::find($subState->state);
      if (!$state) return response()->json('Subestado no asignado a ningun estado existente', 500);

      $allowedRoles = json_decode($state->allowed_roles);

      if ($user)
        if (!in_array($user->role,$allowedRoles) && !$ignore)
          return response()->json('No tienes permisos de implementar este subestado en la linea', 403);

      if ($specify)
        if ($line->canceled == 1) return response()->json('La linea se encuentra cancelada', 400);
      else
        if ($line->canceled == 1) return false;

      switch ($state->id) {
        case 10:/* Acciones en caso de fallar manualmente la linea */
        break;
        case 9:
          // Acciones en caso de cancelar manualmente la linea
          // - El stock asociado se desasocia
          // - Borrar el IMEI de la linea
          // - cancelated = 1
          // Otras cosas.
          if ($line->canceled == 1) return response()->json('Linea Ya Cancelada', 500);
          $stock = DB::table('stocks')->where('line',$line->id)->first();
          $stock = Stock::find($stock['id']);
          if ($stock){
            $stock->line = null;
            if (!$stock->save()) return response()->json('Error al editar estado de la linea', 500);
          }

          $line->imei = null;
          $line->canceled = 1;
          if (!$line->save()) return response()->json('Error al editar estado de la linea', 500);

          if ($specify) {
            History::Entry($line->sale, 'Linea cancelada',
            Auth::user()->name.' ha CANCELADO la linea #'.$line->id,
             'fa fa-ban', ['seller' => ''.Auth::user()->name.' ha CANCELADO la linea (#'.$line->id.').']);
          }

        break;
        case 8: //TERMINADA OK
          // Acciones en caso de terminar manualmente la linea
          //Da igual el momento en el que se ponga el estado... siempre...
          /*
            SE VALIDA QUE:
            - Se requiere "AMBITO"
            - Se requiere "SUBIR FOTO BCT"
          */
          $line->ok = date('Y-m-d H:i:s');
          $line->finalization = date('Y-m-d H:i:s');
          if (!$line->save()) return response()->json('Error al editar estado de la linea', 500);
        break;
        case 7: // Acciones en caso de poner manualmente "en ruta" una linea
          //VALIDAR: se tiene asignado un motorista
          if ($line->subestado->estado->id == 6) {
            $line->map_assigned_biker = date('Y-m-d H:i:s');
            if (!$line->save()) return response()->json('Error al editar estado de la linea', 500);
          }
        break;
        case 6: //SSTM Y EQUIPO EN BOLSA
          /*
            SE VALIDA QUE:
            - Se requiere "AMBITO"
            - Se requiere "SUBIR FOTO BCT"
          */
          //Da igual el momento en el que se ponga el estado... siempre...
          $line->sstm = date('Y-m-d H:i:s');
          if (!$line->save()) return response()->json('Error al editar estado de la linea', 500);
        break;
        case 5: //CHEQUEO
          //Si el estado anterior era "RECEPCION" (PENDIENTE BODEGA)
          if ($line->subestado->estado->id == 4) {
            $line->warehouse_send = date('Y-m-d H:i:s');
            if (!$line->save()) return response()->json('Error al editar estado de la linea', 500);
          }
        break;
        case 4: //RECEPCION (PENDIENTE BODEGA)
        break;
        case 3: //EN PROCESO
          //Si el estado anterior era "REVISION"
          if ($line->subestado->estado->id == 2) {
            $line->supervisor_send = date('Y-m-d H:i:s');
            if (!$line->save()) return response()->json('Error al editar estado de la linea', 500);
          }
        break;
        case 2: //REVISION
          //Si el estado anterior era "PLANTEAMIENTO"
          //var_dump($line->subestado);exit();
          if ($line->subestado->estado->id == 1) {
            $line->executive_send = date('Y-m-d H:i:s');
            if (!$line->save()) return response()->json('Error al editar estado de la linea', 500);
          }
        break;
        case 1: //PLANTEAMIENTO
          //Si el estado anterior era "REVISION"
          if ($line->subestado->estado->id == 2) {
            //Han devuelto la linea al ejecutivo... pero realmente no pasa mucho
          }
        break;
      }

      /*switch ($substate->id) {
        //acciones segun substado manual
      }*/

      /*var_dump($line->substate);
      var_dump($substate);
      exit();*/

      $line->substate = $substate;
        if (!$line->save()) return response()->json('Error al editar estado de la linea', 500);

      //var_dump($specify);exit();
      if ($specify) {
        History::Entry($line->sale, 'Cambio de subestado',
        Auth::user()->name.' ha cambiado el subestado la linea #'.$line->id.' a '.$subState->name.' ahora se encuentra en el estado '.$state->name.'.',
      'fa fa-exchange', [/*'seller' => ''.Auth::user()->name.' ha cambiado el estado de la linea la linea (#'.$line->id.').'*/]);
      }

      return response()->json('Estado Cambiado', 200);

    }

    public static function comprobateStock($lines) {

      if (!$lines) return ['ok' => false,'message'=>'No haz introducido ninguna linea.']; //ESTO NO ES UN RESPONSE
      if (is_string($lines)) $lines = json_decode($lines,1);
      if (is_object($lines)) $lines = json_decode(json_encode($lines),1);
      if (!is_array($lines) || !sizeof($lines)) return ['ok' => false,'message'=>'No haz introducido ninguna linea.'];

      $stockRequest = [];

      foreach ($lines as $line) {
        $line = (array) $line;
        //Si me haz enviado una linea que ya esta registrada en el servidor con un ID (esta actualizandose)
        if (isset($line['id']) && $line['id'] && $line['id'] !== null) continue;
        if (!isset($line['equipment'])) {
          continue;
        }

        $equipment = Equipment::where('id',$line['equipment'])->first();

        if (!$equipment) return ['ok' => false,'message'=>'El equipo no existe.'];

        if ($equipment) {
          if ($equipment->trash)
            return ['ok' => false,'message'=>'El equipo '.$equipment->name.' esta eliminado.'];

          if (!$equipment->active)
            return ['ok' => false,'message'=>'El equipo '.$equipment->name.' no esta activo.'];
        }

        $encounter = null;
        foreach ($stockRequest as $sKey => $sStock)
          if ($sStock['equipmentID'] == $equipment->id)
            $encounter = $sKey;

        if ($encounter === null) {
          $stockRequest[] = [
            'equipmentID' => $equipment->id,
            'equipment' => $equipment,
            'request' => 1,
          ];
        }else{
          $stockRequest[$encounter]['request'] += 1;
        }

      }

      //if ($stockRequest[])
        //var_dump($stockRequest);exit();

      $gestionAvanzada = true;
      if (!$gestionAvanzada) {
        foreach ($stockRequest as $sKey => $sStock)
          if (($sStock['request'] > $sStock['equipment']->stock) && !$sStock['equipment']->exception) {
            return ['ok' => false,'message'=>'Solo quedan '.(string) $sStock['equipment']->stock.' disponibles de '.$sStock['equipment']->name];
          }
      }else{
        foreach ($stockRequest as $sKey => $sStock)
          if (($sStock['request'] > $sStock['equipment']->really_stock) && !$sStock['equipment']->exception) {
            return ['ok' => false,'message'=>'Solo quedan '.(string) $sStock['equipment']->really_stock.' disponibles de '.$sStock['equipment']->name];
          }
      }

      return ['ok' => true,'message'=>'Todo en orden!'];

    }

    public static function createLine($line,$sale){

        $keysAllow = [
          'sale',
          'type',
          'donor_company',
          'equipment',
          'plan',
          'pcs',
          'chip_price',
          'plan_cost',
          'price',
          'fees',
          'imei',
          'sim',
          'creation',
          'executive_send',
          'supervisor_send',
          'warehouse_send',
          'map_assigned_biker',
          'biker_send',
          'ok',
          'sstm',
          'finalization',
          'ambit'
        ];
        //echo json_encode($line);exit();

        //For debug reasons: IDEA: quitar luego
        if ($line->plan === 0)
          unset($line->plan);

        if ($line->equipment === 0)
          unset($line->equipment);

        $itemToSave = [];

        if (isset($line->company)) $itemToSave['donor_company'] = $line->company;
        unset($line->company);

        ///var_dump($line->pcs);exit();

        foreach ($keysAllow as $key)
          if (isset($line->{$key})) $itemToSave[$key] = $line->{$key};

        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        $itemToSave['sale'] = $sale;
        $itemToSave['creation'] = $date;
        $itemToSave['substate'] = 1;
        $itemToSave['ambit'] = 'none';
        //var_dump($itemToSave);exit();
        return Line::create($itemToSave);
    }

    public static function updateLine($line){


        $exists = Line::find($line->id);
        if (!$exists) return null;

        $line = (array) $line;


        $keysAllow = [
          'type',
          'donor_company',
          'plan',
          'pcs',
          'chip_price',
          'plan_cost',
          'price',
          'fees',
        ];

        $itemToSave = [];


        //var_dump($line);exit();

        if (isset($line['company'])) $line['donor_company'] = $line['company'];
        unset($line['company']);

        $toSave = [];

        foreach ($keysAllow as $key)
          if (isset($line[$key])) $toSave[$key] = $line[$key];

        //var_dump($toSave['donor_company']);exit();
        $line = Line::where('id',$line['id'])->update($toSave);

        //var_dump($toSave);exit();

        return $line;
    }

    public function subestado(){
      //return $this->hasMany('App\Substate', 'id', 'substate');
      return $this->hasOne('App\Substate', 'id', 'substate');
    }
}
