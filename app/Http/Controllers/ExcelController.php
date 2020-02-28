<?php

namespace App\Http\Controllers;

use App\Helpers\MPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Excel;

class ExcelController extends Controller
{
    public function download($id){
        $excel = Excel::find($id);
        $download_path = ( public_path($excel->file));
        return response()->download($download_path);
    }

    public function getAll(Request $request){
        $excel = Excel::getAll();
        return $excel;
    }
    public function paginate(Request $request){

        $pquery = DB::table('excels');

        try {
            $Excel = MPage::paginate($pquery, $request);
        } catch (\Exception $e) {
            return response()->json('Error al obtener datos', 500);
        }

        return $Excel;
    }

    public function find($id){
        $Excel = Excel::find($id);
        return response()->json($Excel, 200);
    }
}
