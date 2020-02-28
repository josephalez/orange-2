<?php

namespace App\Http\Controllers;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    public function getRegions(){
      $regions = Region::get();
      if (!$regions) return response()->json('Database Error', 500);
      return response()->json($regions);
    }
}
