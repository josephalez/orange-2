<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Line;
use Auth;

class LineController extends Controller
{
  public function changeSubstate($id, Request $request)
  {
    $data = $request->all();
    $change = Line::changeState($id, $data['substate'], Auth::user(), false, true);
    if (!$change) return response()->json('Error al editar estado de la linea', 500);
    return $change;
  }

    public function CancelLine($id)
    {
      $change = Line::changeState($id, 16, Auth::user(), true, true);
      if (!$change) return response()->json('Error al editar estado de la linea', 500);
      return $change;
    }
}
