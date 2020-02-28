<?php

namespace App\Http\Controllers;
use App\Commune;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CommuneController extends Controller
{
    public function getCommunes(){
      $communes = Commune::get();
      if (!$communes) return response()->json('Database Error', 500);
      return response()->json($communes);
    }
}
