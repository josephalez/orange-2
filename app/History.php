<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;
use Auth;

class History extends Model
{

    protected $fillable = [
      'title',
      'description',
      'icon',
      'sale',
      'by',
    ];

    public static function Entry($sale, $title = 'Nueva entrada de historial', $desc = null, $icon = 'fa fa-bell', $eventFor = [] , $userNull = false) {
      //Example: History::Entry($sale, 'Aprobacion de venta', ''.Auth::user()->nombre.' ha aprobado la venta #'.$id.'.', 'fa fa-check', ['seller' => ''.Auth::user()->nombre.' ha aprobado tu venta (#'.$id.').']);
      //var_dump('olaaa');exit();
      $userId = null;
      if (!$userNull) {
        $user = Auth::user();
        if ($user) $userId = $user->id;
      }

      if (!$desc)
        $desc = 'Se notifica que '.$title;

      $eventBody = [
        'title' => $title,
        'description' => $desc,
        'icon' => $icon,
        'sale' => $sale,
        'by' => $userId,
      ];
      //var_dump('ola');exit();
      Event::bySellTo($sale, $eventFor, $title, $desc, $icon, $userId);

      //var_dump($eventBody);exit();

      return History::create($eventBody);

    }

}
