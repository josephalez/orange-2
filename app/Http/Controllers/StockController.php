<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Imports\StockImport;
use Illuminate\Support\Facades\DB;
use App\Helpers\MPage;
use App\Excel as ExcelFile;
use App\Stock;

class StockController extends Controller
{
    public function import(Request $request)
    {
        $validator=Validator::make($request->all(),[
          'file'=>'required|max:5242880|mimes:xlsx'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $valImeiCut = ($request->input('imeiCut')) ? true : false;
        session([ 'jsonExcel'=>[] , 'imeiCut' => $valImeiCut ]);

        Excel::import(new StockImport,request()->file('file'));

        $jsonExcel = session('jsonExcel');

        $file = request()->file('file');
        $carpetaDestino = 'uploads/stock';
        $nombreArchivo = 'excel_'.uniqid().'_'.$file->getClientOriginalName();

        $urlExcel = $file->move($carpetaDestino,$nombreArchivo);
        $nombreOriginal = $file->getClientOriginalName();
        $details = json_encode($jsonExcel);

        $data = [
          'originalName' => $nombreOriginal,
          'file' => $urlExcel,
          'details' => $details
        ];

        $newExcelData = ExcelFile::createExcel($data);
        if (!$newExcelData) return response()->json("Database Error", 500);


        return response()->json("Documento Cargado Satisfactoriamente", 200);
    }

    public function paginate(Request $request){

        $pquery = DB::table('stocks')->where('stocks.trash', 0)
        ->leftjoin('lines', 'lines.id', '=', 'stocks.line')
        ->leftjoin('equipments', 'equipments.id', '=', 'stocks.equipment')
        ->leftjoin('sales', 'sales.id', '=', 'lines.sale')
        ->leftjoin('substates', 'substates.id', '=', 'lines.substate')
        ->leftjoin('clients', 'clients.id', '=', 'sales.client')
        ->selectRaw('stocks.*,
        lines.pcs as pcs, lines.warehouse_send as warehouse_send,
        equipments.name as name, equipments.image as image,
        sales.id as sale,
        clients.rut as rut,
        substates.name as line_state
        ');

        $stocks = null;

        if($request->input("by_imei")){
            $pquery->where("stocks.imei","=",$request->input("by_imei"));
        }

        if($request->input("pistoleada")){
            //ETOL
        }

        if($request->input("by_equipment")){
            $pquery->where("equipments.id","=",$request->input("by_equipment"));
        }

        if($request->input("finished_ok")){

        }

        try {
            $stocks = MPage::paginate($pquery, $request, 12, '', 'stocks');
        } catch(\Exception $e) {
            return response()->json('Error al obtener datos', 500);
        }

        return $stocks;
    }
}
