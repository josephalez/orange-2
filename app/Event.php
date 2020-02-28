<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Sale;

class Event extends Model
{
    protected $fillable = [
      'title',
      'description',
      'icon',
      'sale',
      'notificationId',
      'by',
      'for',
      'state',
      'oculto',
      'trash',
    ];

  public static function bySellTo($sale = null, $roles = []/*['seller' => null,'supervisor' => null,'analyst' => null,'biker' => null]*/, $title = 'Nuevo evento', $desc = null, $icon = 'fa fa-bell', $userId = null) {


      //var_dump($roles);exit();
      $sale = Sale::find($sale);
      if (!$sale) return null;

      $rolesKeys = [];

      foreach ($roles as $key => $value)
        $rolesKeys[] = $key;

      $rolesIds = [];

      if (in_array('seller',$rolesKeys) && $sale->seller)
        $rolesIds[] = [$sale->seller,$roles['seller']];

      if (in_array('supervisor',$rolesKeys) && $sale->supervisor)
        $rolesIds[] = [$sale->supervisor,$roles['supervisor']];

      if (in_array('analyst',$rolesKeys) && $sale->analyst)
        $rolesIds[] = [$sale->analyst,$roles['analyst']];

      if (in_array('biker',$rolesKeys) && $sale->biker)
        $rolesIds[] = [$sale->biker,$roles['biker']];

      foreach ($rolesIds as $uDta) {
        if (!Event::to($uDta[0], $title, (isset($uDta[1]) && $uDta[1]) ? $uDta[1] : $desc, $sale->id, $icon, $userId))
          return false;
      }

      return true;

    }

    public static function To($toId, $title = 'Nuevo evento', $desc = null, $sale = null, $icon = 'fa fa-bell', $forceUserId = null , $userNull = false) {
      //Example: Event::to(4,'Te ha llegado una venta','Hector Ferrer te ha enviado una venta','fa fa-sell?')
      $userId = null;
      if (!$userNull) {
        $user = Auth::user();
        if ($user) $userId = $user->id;
      }

      if ($forceUserId) $userId = $forceUserId;

      if (!$desc)
        $desc = 'Se notifica que '.$title;

      $eventBody = [
        'title' => $title,
        'description' => $desc,
        'icon' => $icon,
        'sale' => $sale,
        'notificationId' => null,
        'by' => $userId,
        'for' => $toId,
      ];

      return Event::createEvent($eventBody);

    }

    public static function createEvent($request){

        $keysAllow = [
          'title',
          'description',
          'icon',
          'sale',
          'notificationId',
          'by',
          'for',
          'state',
          'oculto',
          'trash',
        ];

        $itemToSave = [];

        foreach ($keysAllow as $key)
          if (isset($request[$key])) $itemToSave[$key] = $request[$key];

        //Mi propio vardump
        //var_dump($itemToSave);exit();

        return Event::create($itemToSave);

    }

    public static function get(){
      $query = DB::table('events')->where('trash', false)->where('oculto',false)
      ->where('for',Auth::user()->id);

      return $query->get();
    }

    public static function viewEvents(){
      $events = DB::table('events')->where('trash', false)->where('state',"alert")->update(['state' => 'viewed']);
      return true;
    }

    public static function eventState($id,$request){

        $event = Event::find($id);
        if (isset($request["state"])){
          $event->state = $request["state"];
        }else {
          $event->oculto = true;
        }
        $event->save();
        return $event;
    }

    public static function removeEvent($id){
        $event = Event::find($id);
        $event->trash = true;
        $event->save();
        return $event;
    }
}
