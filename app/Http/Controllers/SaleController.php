<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Line;
use App\Client;
use Carbon\Carbon;
use App\Helpers\MPage;
use App\Exports\SaleExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\State;
use App\Substate;
use App\History;

class SaleController extends Controller
{
    public static function DCard($title,$frequency = 'mes',$quantity = 0,$subLabel = null,$subQuantity = null, $color = null) {
      return [
        'title' => $title,
        'frequency' => $frequency,
        'quantity' => $quantity,
        'subLabel' => $subLabel,
        'subQuantity' => $subQuantity,
        'color' => $color
      ];
    }

    public function sendTo(Request $request, $saleID = null, $to = 'next' /*back*/) {

        //Validaciones
        $user = Auth::user();

        if (!$saleID) return response()->json('Debe especificar la venta.',400);
        $sale = Sale::find($saleID);

        if (!$sale) return response()->json('La venta no existe.',404);

        if (!in_array($user->role, ['backoffice_general','bodega','mapa']))
          if ($sale->seller != $user->id && $sale->supervisor != $user->id && $sale->analyst != $user->id)
            return response()->json('No tienes permisos de realizar esta accion.',403);

        if (!$to || ($to != 'back' && $to != 'next')) return response()->json('Debes enviar "next" o devolver "back"',400);

        //Action

        switch ($user->role) {
          case 'ejecutivo':

            if ($to == 'back')  return response()->json('No tienes a quien devolver esta venta.',403);
            if (!$sale->haveState(1)) return response()->json('La venta no se encuentra "EN PLANTEAMIENTO".',403);//<--- esta validacion no se esta haciendo


            History::Entry($saleID, 'Envio al supervisor', Auth::user()->nombre.' ha enviado la venta #'.$saleID.' al supervisor, ahora se encuentra en REVISION', 'fa fa-share', ['supervisor' => Auth::user()->nombre.' te ha enviado la venta #'.$saleID]);

            Sale::changeSubState($sale->id,3,true,true,1);
            //var_dump('ola');exit();
          break;
          case 'supervisor':

            if ($to == 'back'){
              if (!$sale->haveState(2)) return response()->json('La venta no se encuentra "EN REVISION".',403);

              History::Entry($saleID, 'Venta desaprobada', ''.Auth::user()->nombre.' ha desaprobado la venta #'.$saleID.', ahora se encuentra en PLANTEAMIENTO', 'fa fa-long-arrow-left', ['supervisor' => Auth::user()->nombre.' ha desaprobado la venta #'.$saleID, 'seller' => Auth::user()->nombre.' ha desaprobado tu venta, venta #'.$saleID]);
              Sale::changeSubState($sale->id,2,true,true,2);
            }else if ($to == 'next'){
              if (!$sale->haveState(2)) return response()->json('La venta no se encuentra "EN REVISION".',403);

              History::Entry($saleID, 'Venta aprobada', ''.Auth::user()->nombre.' ha aprobado la venta #'.$saleID.', ahora se encuentra en PROCESO', 'fa fa-check', ['analyst' => Auth::user()->nombre.' ha aprobado la venta #'.$saleID, 'seller' => Auth::user()->nombre.' ha aprobado tu venta, venta #'.$saleID]);
              Sale::changeSubState($sale->id,5,true,true,2);
            }

          break;
          case 'backoffice':

            if ($to == 'back'){
              if (!$sale->haveState(3)) return response()->json('La venta no se encuentra "EN PROCESO".',403);

              History::Entry($saleID, 'Venta rechazada', ''.Auth::user()->nombre.' ha rechazado la venta #'.$saleID.', ahora se encuentra en REVISION', 'fa fa-times', ['supervisor' => Auth::user()->nombre.' ha rechazado la venta #'.$saleID, 'seller' => Auth::user()->nombre.' ha rechazado tu venta, venta #'.$saleID]);/**/
              Sale::changeSubState($sale->id,4,true,true,3);
            }else if ($to == 'next'){
              if (!$sale->haveState(3)) return response()->json('La venta no se encuentra "EN PROCESO".',403);

              History::Entry($saleID, 'Venta procesada', ''.Auth::user()->nombre.' ha procesado la venta #'.$saleID.', ahora se encuentra en RECEPCION y esta PENDIENTE BODEGA', 'fa fa-cog', ['supervisor' => Auth::user()->nombre.' ha procesado la venta #'.$saleID, 'seller' => Auth::user()->nombre.' ha procesado tu venta, venta #'.$saleID]);
              Sale::changeSubState($sale->id,6,true,true,3);
            }

          break;
          case 'bodega':
            // code...
          break;
          default:
            return response()->json('No tiene nada que hacer en esta accion.',400);
          break;
        }

        return response()->json('Accion realizada con exito!',200);

    }

    public function dashboard(){
      $user = Auth::user();

      //Data
      $data = [];
      $dataCards = [];

      switch ($user->role) {
        case 'ejecutivo': //Ejecutivo

          //Que seas el vendedor
          $querySeller = Sale::where('sales.seller','=',$user->id);

          //INNER JOIN EN LINEAS
          $querySeller->leftjoin('lines','lines.sale','=','sales.id');

          //INNER JOIN DEL SUBESTADO Y ESTADO;
          $querySeller->join('substates', 'lines.substate', '=', 'substates.id')
          ->join('states', 'substates.state', '=', 'states.id');

          //QUERY SELLER LINE DISTINCT Y AGRUPACION;
          $querySellerLine = clone $querySeller;
          $querySellerLine/*->groupBy('lines.id')*/->distinct('lines.id');

          //QUERY SELLER SE AGRUPA POR LAS VENTAS
          $querySeller/*->groupBy('sales.id')*/->distinct('sales.id');

          $linesParam1 = clone $querySellerLine; $salesParam1 = clone $querySeller;
          $linesParam2  = clone $querySellerLine; $salesParam2  = clone $querySeller;
          $linesParam3 = clone $querySellerLine; $salesParam3 = clone $querySeller;
          $linesParam4 = clone $querySellerLine; $salesParam4 = clone $querySeller;

          //FECHAS
          //>Las registradas solo se contara la fecha de creacion este mes
          $linesParam1->where(DB::raw('MONTH(lines.created_at)'), '=', date('n'))
          ->whereRaw('year(lines.created_at) = ?', array(date('Y')));
          $salesParam1->where(DB::raw('MONTH(lines.created_at)'), '=', date('n'))
          ->whereRaw('year(lines.created_at) = ?', array(date('Y')));

          //>Para las terminadas se tomara en cuenta la fecha en que se terminaron
          $linesParam2->where(DB::raw('MONTH(lines.ok)'), '=', date('n'))
          ->whereRaw('year(lines.ok) = ?', array(date('Y')));
          $salesParam2->where(DB::raw('MONTH(lines.ok)'), '=', date('n'))
          ->whereRaw('year(lines.ok) = ?', array(date('Y')));

          //>Para las en proceso se tomaran en cuenta la fecha en que fueron puestas en proceso
          $linesParam3->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));
          $salesParam3->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));

          //>Para las canceladas pues la fecha de creacion igual que las registradas
          $linesParam4->where(DB::raw('MONTH(lines.created_at)'), '=', date('n'))
          ->whereRaw('year(lines.created_at) = ?', array(date('Y')));
          $salesParam4->where(DB::raw('MONTH(lines.created_at)'), '=', date('n'))
          ->whereRaw('year(lines.created_at) = ?', array(date('Y')));

          //Condiciones para "terminadas"
            $linesParam2->where('states.id','=',8);
            $salesParam2->where('states.id','=',8);
          //Condiciones para "en proceso"
            $linesParam3->where('states.id','=',3);
            $salesParam3->where('states.id','=',3);
          //Condiciones para "fallidas o canceladas"
            $linesParam4->where(
              function ($subQuery) {
                $subQuery->where('states.id','=',9)->orWhere('states.id','=',10)
                ->orWhere('lines.canceled','=',1);
              }
            );
            $salesParam4->where(
              function ($subQuery) {
                $subQuery->where('states.id','=',9)->orWhere('states.id','=',10)
                ->orWhere('lines.canceled','=',1);
              }
            );

          $dataCards = [
            SaleController::DCard('Líneas registradas',           'mes',
              $linesParam1->count('lines.id'),
              'Ventas registradas',           $salesParam1->count('sales.id'),'#1c84c6'),
            SaleController::DCard('Líneas terminadas',            'mes',
              $linesParam2->count('lines.id'),
              'Ventas terminadas',            $salesParam2->count('sales.id'),'#1ab394'),
            SaleController::DCard('Líneas procesandose',               'mes',
              $linesParam3->count('lines.id'),
              'Ventas procesandose',               $salesParam3->count('sales.id'),'#f8ac59'/*'#23c6c8'*/),
            SaleController::DCard('Líneas fallidas', 'mes',
              $linesParam4->count('lines.id'),
              'Ventas fallidas', $salesParam4->count('sales.id'),'#ed5565'),
          ];

        break;

        case 'supervisor': //Supervisor

          //Que seas el vendedor o supervisor
          $querySeller = Sale::where(
            function ($subQuery) use ($user) {
              $subQuery
                ->where('sales.seller',$user->id)
                ->orWhere('sales.supervisor',$user->id)
                ;
            }
          );

          //INNER JOIN EN LINEAS
          $querySeller->leftjoin('lines','lines.sale','=','sales.id');

          //INNER JOIN DEL SUBESTADO Y ESTADO;
          $querySeller->join('substates', 'lines.substate', '=', 'substates.id')
          ->join('states', 'substates.state', '=', 'states.id');

          //QUERY SELLER LINE DISTINCT Y AGRUPACION;
          $querySellerLine = clone $querySeller;
          $querySellerLine/*->groupBy('lines.id')*/->distinct('lines.id');

          //QUERY SELLER SE AGRUPA POR LAS VENTAS
          $querySeller/*->groupBy('sales.id')*/->distinct('sales.id');

          $linesParam1 = clone $querySellerLine; $salesParam1 = clone $querySeller;
          $linesParam2  = clone $querySellerLine; $salesParam2  = clone $querySeller;
          $linesParam3 = clone $querySellerLine; $salesParam3 = clone $querySeller;
          $linesParam4 = clone $querySellerLine; $salesParam4 = clone $querySeller;
          $linesParam5 = clone $querySellerLine; $salesParam5 = clone $querySeller;
          $linesParam6  = clone $querySellerLine; $salesParam6  = clone $querySeller;
          $linesParam7 = clone $querySellerLine; $salesParam7 = clone $querySeller;
          $linesParam8 = clone $querySellerLine; $salesParam8 = clone $querySeller;

          //FECHAS
          //>Para las lineas y ventas que esten en proceso en este momento, fecha en que el supervisor las aprobo
          $linesParam3->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));
          $salesParam3->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));

          //Condiciones para "en planteamiento"
            $linesParam1->where('states.id','=',1);
            $salesParam1->where('states.id','=',1);
          //Condiciones para "pendientes de aprobacion"
            $linesParam2->where('substates.id','=',3);//Revision - Enviada al supp
            $salesParam2->where('substates.id','=',3);//Revision - Enviada al supp
          //Condiciones para "en proceso"
            $linesParam3->where('states.id','=',3);
            $salesParam3->where('states.id','=',3);
          //Condiciones para "rechazadas por backoffice"
            $linesParam4->where('substates.id','=',4);//Revision - Rechazada por backoffice
            $salesParam4->where('substates.id','=',4);//Revision - Rechazada por backoffice

          //Condiciones para "fallidas"
            $linesParam5->where('states.id','=',10);
            $salesParam5->where('states.id','=',10);
          //Condiciones para "canceladas"
            $linesParam6->where('states.id','=',9);
            $salesParam6->where('states.id','=',9);
          //Condiciones para "en ruta"
            $linesParam7->where('states.id','=',7);
            $salesParam7->where('states.id','=',7);
          //Condiciones para "terminadas"
            $linesParam8->where('states.id','=',8);
            $salesParam8->where('states.id','=',8);

            /*
            -Ventas que tiene el ejecutivo (azul)
            -Ventas pendientes por mi (claro)
            -Ventas en Proceso (amarillo)
            -Ventas devueltas al supervisor (rojo) (siempre)

            -Ventas Fallidas
            -Ventas Canceladas
            -Ventas En Ruta
            -Ventas Terminadas OK
            */

            //CONTADORES
            $linesParam1 = $linesParam1->count('lines.id');
            $salesParam1 = $salesParam1->count('sales.id');

            $linesParam2 = $linesParam2->count('lines.id');
            $salesParam2 = $salesParam2->count('sales.id');

            $linesParam3 = $linesParam3->count('lines.id');
            $salesParam3 = $salesParam3->count('sales.id');

            $linesParam4 = $linesParam4->count('lines.id');
            $salesParam4 = $salesParam4->count('sales.id');

            $linesParam5 = $linesParam5->count('lines.id');
            $salesParam5 = $salesParam5->count('sales.id');

            $linesParam6 = $linesParam6->count('lines.id');
            $salesParam6 = $salesParam6->count('sales.id');

            $linesParam7 = $linesParam7->count('lines.id');
            $salesParam7 = $salesParam7->count('sales.id');

            $linesParam8 = $linesParam8->count('lines.id');
            $salesParam8 = $salesParam8->count('sales.id');

          $dataCards = [
            SaleController::DCard('Líneas planteandose', 'ahora',
              $linesParam1,'Ventas planteandose',$salesParam1,'#1c84c6'),
            SaleController::DCard('Líneas pendientes', 'ahora',
              $linesParam2,'Ventas pendientesr', $salesParam2,'#23c6c8'),
            SaleController::DCard('Líneas procesandose', 'mes',
              $linesParam3,'Ventas procesandose', $salesParam3, '#f8ac59'),
            SaleController::DCard('Líneas Rechazadas', 'ahora',
              $linesParam4,'Ventas Rechazadas', $salesParam4, '#ed5565'),

            SaleController::DCard('Líneas fallidas', 'ahora',
              $linesParam4,'Ventas fallidas', $salesParam4, '#ed5565'),
            SaleController::DCard('Líneas canceladas', 'ahora',
              $linesParam4,'Ventas canceladas', $salesParam4, '#ed5565'),
            SaleController::DCard('Líneas en ruta', 'ahora',
              $linesParam4,'Ventas en ruta', $salesParam4, '#f8ac59'),
            SaleController::DCard('Líneas terminadas', 'ahora',
              $linesParam4,'Ventas terminadas', $salesParam4, '#1ab394'),
          ];

        break;

        case 'backoffice': //Backoffice

          //Que seas el vendedor, supervisor o backoffice
          $querySeller = Sale::where(
            function ($subQuery) use ($user) {
              $subQuery
                ->where('sales.seller',$user->id)
                ->orWhere('sales.supervisor',$user->id)
                ->orWhere('sales.analyst',$user->id)
                ;
            }
          );

          //INNER JOIN EN LINEAS
          $querySeller->leftjoin('lines','lines.sale','=','sales.id');

          //INNER JOIN DEL SUBESTADO Y ESTADO;
          $querySeller->join('substates', 'lines.substate', '=', 'substates.id')
          ->join('states', 'substates.state', '=', 'states.id');

          //QUERY SELLER LINE DISTINCT Y AGRUPACION;
          $querySellerLine = clone $querySeller;
          $querySellerLine/*->groupBy('lines.id')*/->distinct('lines.id');

          //QUERY SELLER SE AGRUPA POR LAS VENTAS
          $querySeller/*->groupBy('sales.id')*/->distinct('sales.id');

          $linesParam1 = clone $querySellerLine; $salesParam1 = clone $querySeller;
          $linesParam2  = clone $querySellerLine; $salesParam2  = clone $querySeller;
          $linesParam3 = clone $querySellerLine; $salesParam3 = clone $querySeller;
          $linesParam4 = clone $querySellerLine; $salesParam4 = clone $querySeller;

          //FECHAS
          //>Para las en proceso se tomaran en cuenta la fecha en que fueron puestas en proceso
          $linesParam1->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));
          $salesParam1->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));

          //>Para las terminadas se tomara en cuenta la fecha en que se terminaron
          $linesParam2->where(DB::raw('MONTH(lines.ok)'), '=', date('n'))
          ->whereRaw('year(lines.ok) = ?', array(date('Y')));
          $salesParam2->where(DB::raw('MONTH(lines.ok)'), '=', date('n'))
          ->whereRaw('year(lines.ok) = ?', array(date('Y')));

          //>Para las en pendiente bodega se tomaran en cuenta la fecha en que fueron puestas en proceso
          $linesParam3->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));
          $salesParam3->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));

          //>Para las canceladas pues la fecha de creacion
          $linesParam4->where(DB::raw('MONTH(lines.created_at)'), '=', date('n'))
          ->whereRaw('year(lines.created_at) = ?', array(date('Y')));
          $salesParam4->where(DB::raw('MONTH(lines.created_at)'), '=', date('n'))
          ->whereRaw('year(lines.created_at) = ?', array(date('Y')));

          //Condiciones para "en proceso"
            $linesParam1->where('states.id','=',3);
            $salesParam1->where('states.id','=',3);
          //Condiciones para "terminadas"
            $linesParam2->where('states.id','=',8);
            $salesParam2->where('states.id','=',8);
          //Condiciones para "pendiente bodega"
            $linesParam3->where('states.id','=',4);
            $salesParam3->where('states.id','=',4);
          //Condiciones para "fallidas o canceladas"
            $linesParam4->where(
              function ($subQuery) {
                $subQuery->where('states.id','=',9)->orWhere('states.id','=',10)
                ->orWhere('lines.canceled','=',1);
              }
            );
            $salesParam4->where(
              function ($subQuery) {
                $subQuery->where('states.id','=',9)->orWhere('states.id','=',10)
                ->orWhere('lines.canceled','=',1);
              }
            );

          $dataCards = [
            SaleController::DCard('Líneas procesandose',           'mes',
              $linesParam1->count('lines.id'),
              'Ventas en proceso',           $salesParam1->count('sales.id'),'#1c84c6'),
            SaleController::DCard('Líneas terminadas',            'mes',
              $linesParam2->count('lines.id'),
              'Ventas terminadas',            $salesParam2->count('sales.id'),'#1ab394'),
            SaleController::DCard('Líneas recepción',               'mes',
              $linesParam3->count('lines.id'),
            'Ventas Recepción',               $salesParam3->count('sales.id'),'#f8ac59'/*'#23c6c8'*/),
            SaleController::DCard('Líneas fallidas', 'mes',
              $linesParam4->count('lines.id'),
              'Ventas fallidas', $salesParam4->count('sales.id'),'#ed5565'),
          ];

        break;

        case 'bodega': //Bodega

          //No hace falta que seas el vendedor, supervisor o backoffice
          $querySeller = Sale::select('*');
          //INNER JOIN EN LINEAS
          $querySeller->leftjoin('lines','lines.sale','=','sales.id');
          //INNER JOIN DEL SUBESTADO Y ESTADO;
          $querySeller->join('substates', 'lines.substate', '=', 'substates.id')
          ->join('states', 'substates.state', '=', 'states.id');

          //QUERY SELLER LINE DISTINCT Y AGRUPACION;
          $querySellerLine = clone $querySeller;
          $querySellerLine/*->groupBy('lines.id')*/->distinct('lines.id');

          //QUERY SELLER SE AGRUPA POR LAS VENTAS
          $querySeller/*->groupBy('sales.id')*/->distinct('sales.id');

          $linesParam1 = clone $querySellerLine; $salesParam1 = clone $querySeller;
          $linesParam3 = clone $querySellerLine; $salesParam3 = clone $querySeller;
          $linesParam4 = clone $querySellerLine; $salesParam4 = clone $querySeller;

          //FECHAS
          //>Para las motorista asignado se tomaran en cuenta la fecha en que fueron asignadas
          $linesParam1->whereDate('lines.map_assigned_biker', '=', date('Y-m-d'))->whereNotNull('lines.map_assigned_biker')->whereNotNull('sales.biker');
          $salesParam1->whereDate('lines.map_assigned_biker', '=', date('Y-m-d'))->whereNotNull('lines.map_assigned_biker')->whereNotNull('sales.biker');

          //>Para las en pendiente bodega se tomaran en cuenta la fecha en que fueron puestas en proceso
          $linesParam3->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));
          $salesParam3->where(DB::raw('MONTH(lines.supervisor_send)'), '=', date('n'))
          ->whereRaw('year(lines.supervisor_send) = ?', array(date('Y')));

          //>Para las canceladas pues la fecha de creacion
          $linesParam4->where(DB::raw('MONTH(lines.created_at)'), '=', date('n'))
          ->whereRaw('year(lines.created_at) = ?', array(date('Y')));
          $salesParam4->where(DB::raw('MONTH(lines.created_at)'), '=', date('n'))
          ->whereRaw('year(lines.created_at) = ?', array(date('Y')));

          //Condiciones para "en proceso"
            $linesParam3->where('states.id','=',3);
            $salesParam3->where('states.id','=',3);
          //Condiciones para "fallidas o canceladas"
            $linesParam4->where(
              function ($subQuery) {
                $subQuery->where('states.id','=',9)->orWhere('states.id','=',10)
                ->orWhere('lines.canceled','=',1);
              }
            );
            $salesParam4->where(
              function ($subQuery) {
                $subQuery->where('states.id','=',9)->orWhere('states.id','=',10)
                ->orWhere('lines.canceled','=',1);
              }
            );

          $dataCards = [
            SaleController::DCard('Equipos asignados','hoy',
              $linesParam1->count('lines.id'),
              'Ventas asignadas',
              $salesParam1->count('sales.id'),
              '#1c84c6'
            ),
            SaleController::DCard('Equipos procesandose',           'mes',
              $linesParam3->count('lines.id'),
              'Ventas procesandose',
              $salesParam3->count('sales.id'),
              '#f8ac59'
            ),
            SaleController::DCard('Líneas fallidas', 'mes',
              $linesParam4->count('lines.id'),
              'Ventas fallidas',
              $salesParam4->count('sales.id'),
              '#ed5565'
            ),
          ];

        break;

      }

      $data = [
        'dataCards' => $dataCards,
      ];

      return $data;
    }

    public static function DateRange($query,$date,$param,$tableName){
      if(is_array($date)){
        $startDate=$date[0];
        $endDate=$date[1];

        return $query->whereBetween($tableName.'.'.$param,[$startDate,$endDate]);
        //where($tableName.'.'.$param, '>=', $startDate)
        //->where($tableName.'.'.$param, '<=', $endDate);
      }

      return $query->where($tableName.'.'.$param,'=',$date);
    }

    public static function Keywords($queryArray, $keyword){

      return $queryArray->where(function ($query) use($keyword) {
        $query->where("sales.id", '=', $keyword);
        $query->orWhere('clients.rut', 'LIKE', "%{$keyword}%");
        $query->orWhere('clients.id', '=', $keyword);
        $query->orWhere('lines.id', '=', $keyword);
        //$query->orwhere("sales.", 'LIKE', "%{$keyword}%");
        $query->orWhere('clients.name', 'LIKE', "%{$keyword}%");
        $query->orWhere('clients.phone', '=', $keyword);
        $query->orWhere('clients.last_name', 'LIKE', "%{$keyword}%");
        $query->orWhere('clients.last_name_2', 'LIKE', "%{$keyword}%");
        $query->orWhere('clients.address', 'LIKE', "%{$keyword}%");
        $query->orWhere('lines.imei', '=', $keyword);
        $query->orWhere('lines.pcs', '=', $keyword);
        $query->orWhere('lines.sim', '=', $keyword);
        //$query->orWhere('lines.', 'LIKE', "%{$keyword}%");
      });

    }

    public function paginate(Request $request){

      $sales = DB::table('sales');

      $sales->select('sales.*','clients.rut','clients.name','clients.last_name','clients.last_name_2',
      'states.name as Estado','substates.name as Subestado',
      DB::raw('concat(clients.name, " ", clients.last_name) as clientFullName'))
      //->distinct('sales.id')
      ->groupBy('sales.id')
      ->join('clients', 'clients.id', '=', 'sales.client')
      ->leftjoin('lines', 'lines.sale', '=', 'sales.id')
      ->selectRaw('sales.*, count(lines.id) as linesCount')
      /*if($request->input("no_cancel")){
        $sales->join('lines as lines2', function ($join) {
          $join->on('lines2.sale', '=', 'sales.id');
          //$join->on('lines2.canceled', '=', 'sales.id');
        });
      }*/
      ->join('substates', 'lines.substate', '=', 'substates.id')
      ->join('states', 'substates.state', '=', 'states.id')
      /*->select('users.*', 'contacts.phone', 'orders.price')*/;

      if ($request->input('in_state')) {
        /*- SOLO ver las ventas con almenos una de sus lineas en un subestado
        especificado por un parametro */
        $sales->where('states.id','=',$request->input('in_state'));
      }

      if ($request->input('in_substate')) {
        /*- SOLO ver las ventas con almenos una de sus lineas en un subestado
        especificado por un parametro */
        $sales->where('lines.substate','=',$request->input('in_substate'));
      }

      if ($request->input('orderby_rut')) {
        /* rut chocaba con*/
        $sales->orderBy("clients.rut", (strtoupper($request->input('orderby_rut')) == 'ASC') ? 'ASC' : 'DESC');

      }

      if ($request->input('one_cancel')) {
        /*- SOLO ver las ventas con almenos una de sus lineas canceladas. */
        $sales->where('lines.canceled','=',1);
      }

      if ($request->input('one_valid')) {
        $sales->where('lines.canceled','=',0);
      }

      /*if ($request->input('no_cancel')) {
        $sales->whereNotExists(function ($query) {
          $query->where('lines.canceled','=',1);
        });
      }*/

      if ($request->input('in_ambit')) {

        $ambits = [
          "none",
          "fisica",
          "digital",
          "ambas",
          "otro",
        ];
        //- SOLO ver las ventas con almenos una de sus lineas en un ambito cualquiera (none, fisica, digital, ambas, otro).

        if(in_array($request->input("in_ambit"), $ambits)){

            $sales->where('lines.ambit','=',$request->input("in_ambit"));

        }
      }


      if ($request->input('donor_company')) {
        //- SOLO ver las ventas con almenos una de sus lineas en un ambito cualquiera (none, fisica, digital, ambas, otro).

        $companies=[
          "none",
          "Won",
          "Entel",
          "Vtr",
          "claro",
          "virgin",
          "movistar",
        ];

        if(in_array($request->input("donor_company"),$companies)){
            $sales->where('lines.donor_company','=',$request->input("donor_company"));
        }
      }

      if ($request->input('in_type')) {
        //- Solo ver las ventas con almenos una de sus lineas en un type especificado
        $companies=[
          "none",
          "nueva_linea",
          "migracion",
          "portabilidad",
          "bam",
        ];

        if(in_array($request->input("in_type"),$companies)){
            $sales->where('lines.type','=',$request->input("in_type"));
        }
      }

      if ($request->input('in_type')) {
        //- Solo ver las ventas con almenos una de sus lineas en un type especificado
        $companies=[
          "none",
          "nueva_linea",
          "migracion",
          "portabilidad",
          "bam",
        ];

        if(in_array($request->input("in_type"),$companies)){
            $sales->where('lines.type','=',$request->input("in_type"));
        }
      }

      if ($request->input('createdStart')) {
        if($request->input("createdEnd")){
          $dates=[
            "0"=>$request->input('createdStart'),
            "1"=>$request->input("createdEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"creation","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("createdStart"),"creation","lines");
      }


      if ($request->input('executiveStart')) {
        if($request->input("executiveEnd")){
          $dates=[
            "0"=>$request->input('executiveStart'),
            "1"=>$request->input("executiveEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"executive_send","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("executiveStart"),"executive_send","lines");

      }

      if ($request->input('supervisorStart')) {
        if($request->input("supervisorEnd")){
          $dates=[
            "0"=>$request->input('supervisorStart'),
            "1"=>$request->input("supervisorEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"supervisor_send","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("supervisorStart"),"supervisor_send","lines");

      }

      if ($request->input('warehouseStart')) {
        if($request->input("warehouseEnd")){
          $dates=[
            "0"=>$request->input('warehouseStart'),
            "1"=>$request->input("warehouseEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"warehouse_send","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("warehouseStart"),"warehouse_send","lines");
      }

      if ($request->input('bikerAssignedStart')) {
        if($request->input("bikerAssignedEnd")){
          $dates=[
            "0"=>$request->input('bikerAssignedStart'),
            "1"=>$request->input("bikerAssignedEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"map_assigned_biker","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("bikerAssignedStart"),"map_assigned_biker","lines");

      }

      if ($request->input('bikerStart')) {
        if($request->input("bikerEnd")){
          $dates=[
            "0"=>$request->input('bikerStart'),
            "1"=>$request->input("bikerEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"biker_send","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("bikerStart"),"biker_send","lines");

      }

      if ($request->input('okStart')) {
        if($request->input("okEnd")){
          $dates=[
            "0"=>$request->input('okStart'),
            "1"=>$request->input("okEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"ok","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("okStart"),"ok","lines");

      }

      if ($request->input('sstmStart')) {
        if($request->input("sstmEnd")){
          $dates=[
            "0"=>$request->input('sstmStart'),
            "1"=>$request->input("sstmEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"sstm","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("sstmStart"),"sstm","lines");

      }

      if ($request->input('finalizationStart')) {
        if($request->input("finalizationEnd")){
          $dates=[
            "0"=>$request->input('finalizationStart'),
            "1"=>$request->input("finalizationEnd"),
          ];
          $sales=SaleController::DateRange($sales,$dates,"finalization","lines");
        }
        else $sales=SaleController::DateRange($sales,$request->input("finalizationStart"),"finalization","lines");

      }

      if($request->input("search")){
        $keyword=$request->input("search");
        $sales= SaleController::Keywords($sales,$keyword);
      }

      /*(XXX):
      - sells, lines, clients, id //stricts
      - lines pcs //%like%
      - lines imei //%like%
      - lines sim //%like%
      - clients name //%like%
      */

      if ($request->input('IAmSeller')) { //SOLO mias donde sea vendedor
        $sales->where('seller','=',Auth::user()->id);
      }

      if ($request->input('IAmSupervisor')) { //SOLO mias donde sea supervisor
        $sales->where('supervisor','=',Auth::user()->id);
      }

      if ($request->input('IAmAnalyst')) { //SOLO mias donde sea backoffice
        //return response()->json($sales,200);
        $sales->where('analyst','=',Auth::user()->id);
      }


      switch (Auth::user()->role) {
        case 'ejecutivo':
          $sales->where(function ($query) {
              $query->where('seller','=',Auth::user()->id);
          });
        break;
        case 'supervisor':
          $sales->where(function ($query) {
              $query->where('seller','=',Auth::user()->id);
              $query->orWhere('supervisor','=',Auth::user()->id);
          });
        break;
        case 'backoffice':
          $sales->where(function ($query) {
              $query->where('seller',       '=',Auth::user()->id);
              $query->orWhere('supervisor', '=',Auth::user()->id);
              $query->orWhere('analyst',    '=',Auth::user()->id);
          });
        break;
        case 'backoffice_general':
          // SIN CONDICIONES ADICIONALES..., EL ES DIOS.
        break;
      }

      if ($request->input('orderby_linesCount')) { //SOLO mias donde sea vendedor
        $sales->orderBy(DB::raw('count(lines.id)'), (strtoupper($request->input('orderby_linesCount')) == 'ASC') ? 'ASC' : 'DESC');
      }

      if ($request->input('orderby_clientFullName')) {
        $sales->orderBy(DB::raw('concat(clients.name, " ", clients.last_name)'),
         (strtoupper($request->input('orderby_clientFullName')) == 'ASC') ? 'ASC' : 'DESC');
      }

      if ($request->input('orderby_Estado')) {
        $sales->orderBy(DB::raw('states.name'), (strtoupper($request->input('orderby_Estado')) == 'ASC') ? 'ASC' : 'DESC');
      }

      /*Falta hacer filtros para*/
      //- No ver las ventas con TODAS sus lineas canceladas.
      //- SOLO ver las ventas con almenos una de sus lineas en un subestado especificado por un parametro
      //- SOLO ver las ventas con almenos una de sus lineas canceladas.

      //- SOLO ver las ventas con almenos una de sus lineas en un ambito cualquiera (none, fisica, digital, ambas, otro).

      //- Solo ver las ventas con almenos una de sus lineas en un donor_company especificado

      //- Solo ver las ventas con almenos una de sus lineas en un type especificado


      //Otros filtros
      //- SOLO ver las ventas con almenos una de sus lineas con "creation" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)
      //- SOLO ver las ventas con almenos una de sus lineas con "executive_send" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)
      //- SOLO ver las ventas con almenos una de sus lineas con "supervisor_send" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)
      //- SOLO ver las ventas con almenos una de sus lineas con "warehouse_send" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)
      //- SOLO ver las ventas con almenos una de sus lineas con "map_assigned_biker" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)
      //- SOLO ver las ventas con almenos una de sus lineas con "biker_send" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)
      //- SOLO ver las ventas con almenos una de sus lineas con "ok" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)
      //- SOLO ver las ventas con almenos una de sus lineas con "sstm" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)
      //- SOLO ver las ventas con almenos una de sus lineas con "finalization" en el rango especificado (si se envia uno solo, no es un rango es una sola fecha)

      //===============================================

      /*FILTROS MAS ESPECIFICOS*/
      //- Filtrar / Buscar venta con la linea que tenga un (XXX) especificado:
        /*(XXX):
          - sells, lines, clients, id //stricts
          - lines pcs //%like%
          - lines imei //%like%
          - lines sim //%like%
          - clients name //%like%
        */

      /*
        ENVIAR AL FRONTEND EL ESTADO SEGUN PRIORIDAD PRICIPAL DE LA VENTA
        (el estado principal de la venta se determina cuando almenos 1 linea
        esta en un estado, este estado si tiene mas "prioridad" o "viene luego"
        de los anteriores es el estado principal)
      */

      $salesPaginated = MPage::paginate($sales, $request,10,'','sales');

      return response()->json($salesPaginated,200);

    }

    protected function createSale(Request $request){

        $validator = Validator::make($request->all(), [

            //Validaciones de cliente

            'rut'                   => 'required|string|min:7|max:13',
            'name'                  => 'required|string|min:2|max:32',
            'last_name'             => 'string|min:2|max:16',
            'email'             => 'string|min:2|max:190',
            'last_name_2'           => 'string|min:2|max:16',
            'phone'                 => 'required|string|min:8|max:16',
            'address'               => 'string|min:2|max:190',
            'carnet'                => 'required|string|min:7|max:16',
            'birthday'              => 'required|date|date_format:Y-m-d',
            'carnet_expiration'     => 'required|date|date_format:Y-m-d',
            'type'                  => 'required|in:person,business_person,pyme,company,corporation',
            'comuna'                => 'required|exists:communes,id',
            'class'                 => 'required|in:normal,bci',

            //Validaciones de Venta

            'observation'           => 'string|max:190',
            //Creo estas seran validaciones en el propio modelo o manuales pero... x
            /*'seller' => ['required',Rule::exists('users')->where(function ($query) {//El Seller seras siempre tu
              /*
                Si eres ejecutivo o supervisor,
                el seller si o si debes ser tu mismo, si eres backoffice el
                seller puede ser escogido pero si no, no.
              */
          /*    if (in_array(Auth::user()->role,['ejecutivo','supervisor'])) //IDEA: DRY... need make function
                $query->where('id','=',Auth::user()->id);

              $query->whereIn('role', ['ejecutivo','supervisor','backoffice','backoffice_general']);
            })],*/
            'supervisor' => ['required',Rule::exists('users', 'id')->where(function ($query) {

              //IDEA: Validar que si eres ejecutivo este debe estar asignado a ti

              if (in_array(Auth::user()->role,['supervisor'])) //IDEA: DRY... need make function
                $query->where('id','=',Auth::user()->id);

              $query->whereIn('role', ['supervisor','backoffice','backoffice_general']);
            })],
            'analyst' => ['required',Rule::exists('users', 'id')->where(function ($query) {

              //IDEA: Validar que si eres ejecutivo/supervisor este debe estar asignado a ti

              /*if (in_array(Auth::user()->role,['backoffice'])) //IDEA: DRY... need make function
                $query->where('id','=',Auth::user()->id);*/

              $query->whereIn('role', ['backoffice','backoffice_general']);
            })],
            'biker' => [/*'required',*/Rule::exists('users')->where(function ($query) {
              $query->whereIn('role', ['motorista']);
            })],
            //

            'delivery_address'                 => 'required|string|min:7|max:190',
            'delivery_region'                  => 'required|exists:regions,id',
            'delivery_commune'                 => 'required|exists:communes,id',
            'delivery_phone'                   => 'string|min:8|max:16',
            'delivery_date'                    => 'required|date|date_format:Y-m-d',
            'delivery_initial_time'            => 'required|date_format:H:i',
            'delivery_final_time'              => 'required|date_format:H:i|after:delivery_initial_time',
            //Valida que venga luego del tiempo inicial... Laravel es una maravilla

            'delivery_observation'             => 'string|max:190',

            //Validaciones numericas -Hector, hablame de numeros
            'chip_price'                       => 'numeric|between:-999999999.99,+999999999.99',
            'delivery_price'                   => 'numeric|between:-999999999.99,+999999999.99',
            'activation_price'                 => 'numeric|between:-999999999.99,+999999999.99',
            'claro_debt'                       => 'numeric|between:-999999999.99,+999999999.99',
            'agreement_footer'                 => 'numeric|between:-999999999.99,+999999999.99',
            'advance_charge'                   => 'numeric|between:-999999999.99,+999999999.99',
            'total'                            => 'numeric|between:-999999999.99,+999999999.99',

            //JSONS
            'delivery_geographic_location'     => 'string',//is JSON {lat, lng}...
            //Estos no se envian pero igual...
            'other_data'                       => 'string',//is JSON
            'metadata'                         => 'string',//is JSON

        ],[
          'seller.exists'     => 'Este vendedor no es valido',
          'supervisor.exists' => 'Este supervisor no es valido',
          'analyst.exists'    => 'Este analista no es valido',
          'biker.exists'      => 'Este motorista no es valido',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();

        //NORMA GENERAL SIEMPRE
        $_request['seller'] = Auth::user()->id;
        /*
          Eliminando/Formateando cosas que no deberian enviarse en la CREACION de la venta
          IDEA: pasar al modelo
        */

        //VALIDACIONES DE SUPERVISOR/ANALISTA

        //VALIDANDO QUE EL SUPERVISOR SEA TU PADRE Y EL ANALISTA TU ABUELO

        //Eliminando:
        unset($_request['other_data']);
        unset($_request['metadata']);

        //Formateando:
        $_request['other_data'] = json_encode([
          'lc' => null,
          'simcard' => null,
          'pcs' => null,
          'diferencia_excepcionada' => null,
          'excepciones' => [
            0 => false, //Límite de endeudamiento
            1 => false, //Deuda claro
            2 => false, //Meses de antigüedad (1-6)
            3 => false, //Meses de antigüedad (1-13)
            4 => false, //Edad
            5 => false, //Cargo fijo
            6 => false, //Equipo en arriendo
          ],
          'descuento' => null,
        ]);

        $_request['metadata'] = json_encode([
          'meses' => null, //Meses
          'cf' => null, //CF
          'cfa' => null, //CF + A
          'edad' => null, //Edad
          'equipoarriendo' => false, //Equipo en arriendo
          'montodeuda' => null, //Monto de deuda
          'atraso' => false,//Atraso de compañía donante
        ]);

        //VALIDANDO Y TRANSFORMANDO LINEAS
        //var_dump($_request);exit();

        if (isset($_request['lines'])){

          if (is_string($_request['lines'])) $_request['lines'] = json_decode($_request['lines']);

          if (!$_request['lines'] ||  $_request['lines'] === [] || sizeof($_request['lines']) <= 0)
            return response()->json('Debe enviar almenos 1 linea valida',400);

        }else{
          return response()->json('Debe enviar almenos 1 linea valida',400);
        }

        $lineResult = Line::comprobateStock($_request['lines']);
        if (!$lineResult['ok']) return response()->json($lineResult['message'],403);

        $client = DB::table('clients')->where('rut', $_request['rut'])->first();
        if ($client) {
            $activeSell = Client::getActiveSell($client->id);
            if ($activeSell) {
              return response()->json('En este instante hay una venta (linea) para este RUT que esta en '.$activeSell->subestado ,403);
            }
        }

        //FINALMENTE CREAFCION DE VENTA

        $send_to_supervisor = (isset($_request['send'])) ? $_request['send'] : false;
        //var_dump($send_to_supervisor);exit();
        $sale = Sale::createSale($_request, $send_to_supervisor);

        return response()->json(['Venta creada con exito!'],200);
    }

    public function updateSale(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            //Validaciones de Venta

            'observation'           => 'string|max:190',

            'email'             => 'string|min:2|max:190',

            'delivery_address'                 => 'string|min:7|max:190',
            'delivery_region'                  => 'exists:regions,id',
            'delivery_commune'                 => 'exists:communes,id',
            'delivery_phone'                   => 'string|min:8|max:16',
            'delivery_date'                    => 'date|date_format:Y-m-d',
            'delivery_initial_time'            => 'date_format:H:i',
            'delivery_final_time'              => 'date_format:H:i|after:delivery_initial_time',
            //Valida que venga luego del tiempo inicial... Laravel es una maravilla

            'delivery_observation'             => 'string|max:190',

            //Validaciones numericas -Hector, hablame de numeros
            'chip_price'                       => 'numeric|between:-999999999.99,+999999999.99',
            'delivery_price'                   => 'numeric|between:-999999999.99,+999999999.99',
            'activation_price'                 => 'numeric|between:-999999999.99,+999999999.99',
            'claro_debt'                       => 'numeric|between:-999999999.99,+999999999.99',
            'agreement_footer'                 => 'numeric|between:-999999999.99,+999999999.99',
            'advance_charge'                   => 'numeric|between:-999999999.99,+999999999.99',
            'total'                            => 'numeric|between:-999999999.99,+999999999.99',

            //JSONS
            'delivery_geographic_location'     => 'string',//is JSON {lat, lng}...
            //Estos no se envian pero igual...
            'other_data'                       => 'string',//is JSON
            'metadata'                         => 'string',//is JSON

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $_request = $request->all();

        if (isset($_request['lines'])){
          if (is_string($_request['lines'])) $_request['lines'] = json_decode($_request['lines']);
        }

        $lineResult = Line::comprobateStock($_request['lines']);
        if (!$lineResult['ok']) return response()->json($lineResult['message'],403);

        $sale = Sale::updateSale($_request, $id);
        if(!$sale) return response()->json('Error en la Base de datos',500);
        return response()->json('Editado con exito',200);
    }

    public function find($id){

        $user = Auth::user();

        $saleIns = Sale::find($id);
        $sale = DB::table('sales')->where("id", $id)->first();
        if (!$sale) return response()->json('Venta no encontrada', 404);

        $sale->other_data = json_decode($sale->other_data);
        $sale->metadata = json_decode($sale->metadata);

        $lines = Sale::getLines($id);
        $sale->lines = $lines;
        //$sale
        $initialDateTime = $sale->delivery_initial_time;

        $sale->delivery_initial_time  = date('H:i',strtotime($sale->delivery_initial_time));
        $sale->delivery_final_time    = date('H:i',strtotime($sale->delivery_final_time));
        //$sale = array $sale;
        $sale = json_decode(json_encode($sale), 1);//Si no hago esto, no puedo añadir nuevas propiedades
        $sale['delivery_date']          = date('Y-m-d',strtotime($initialDateTime));
        $sale['comments'] = Sale::find($sale['id'])->comments;
        $sale['histories'] = Sale::find($sale['id'])->histories;

        /*
        strtotime($updatedData['start']);
        echo $time = date("Y-m-d H:i:s",$startTime);
        */

        $buttons = [];

        switch ($user->role) {
          case 'ejecutivo':

            if ($saleIns->haveState(1))
              $buttons = [
                'next' => [
                  'label' => 'Enviar',
                  'class' => ''//text-white
                ]
              ];

          break;
          case 'supervisor':

            if ($saleIns->haveState(2))
              $buttons = [
                'back' => [
                  'label' => 'Desaprobar',
                  'class' => ''//text-white
                ],
                'next' => [
                  'label' => 'Aprobar',
                  'class' => ''//text-white
                ]
              ];

          break;
          case 'backoffice':

            if ($saleIns->haveState(3))
              $buttons = [
                'back' => [
                  'label' => 'Rechazar',
                  'class' => ''//text-white
                ],
                'next' => [
                  'label' => 'Procesar',
                  'class' => ''//text-white
                ]
              ];

          break;
          case 'bodega':
          break;
        }

        $sale['buttons'] = $buttons;

        return response()->json($sale, 200);

    }

    public function changeSubState($sale, $substate) {

      $sale = Sale::find($sale);
      if (!$sale) return response()->json('Venta no encontrada', 404);

      $subState = Substate::find($substate);
      if (!$subState) return response()->json('Subestado no existe', 402);

      $state = State::find($subState->state);
      if (!$state) return response()->json('Subestado no asignado a ningun estado existente', 500);

      Sale::changeSubState($sale->id,$substate,false,false);

      if (!$sale) return response()->json('Subestado cambiado con exito en toda la venta.', 200);

    }

    //Unused
    public function changeLineSubState($line, $substate) {
      return Line::changeState($line, $substate, Auth::user(), false, true);
    }

    public function exportToPDF($id){
        $sale = DB::table('sales')->where("id", $id)->first();
        $sale->sale_number = $sale->id;

        $client = DB::table('clients')->where("id", $sale->client)->first();
        $sale->client_id = $client->id;
        $sale->client_rut = $client->rut;
        $sale->client_email = $client->email;
        $sale->client_name = $client->name .' '. $client->last_name;
        $sale->client_carnet = $client->carnet;
        $sale->client_phone = $client->phone;
        $sale->client_type = $client->type;
        $sale->client_class = $client->class;
        $sale->client_birthday = $client->birthday;
        $sale->client_carnetex = $client->carnet_expiration;
        $sale->client_address = $client->address;

        if (isset($sale->seller) && $sale->seller != null && $sale->seller){
          $seller = DB::table('users')->where("id", $sale->seller)->first();
          $sale->seller = $seller->name . ' '. $seller->last_name;
        }
        if (isset($sale->supervisor) && $sale->supervisor != null && $sale->supervisor){
          $supervisor = DB::table('users')->where("id", $sale->supervisor)->first();
          $sale->supervisor = $supervisor->name . ' '. $supervisor->last_name;
        }

        if (isset($sale->analyst) && $sale->analyst != null && $sale->analyst){
          $analyst = DB::table('users')->where("id", $sale->analyst)->first();
          $sale->analyst = $analyst->name . ' '. $analyst->last_name;
        }

        $sale->other_data = json_decode($sale->other_data);
        $sale->metadata = json_decode($sale->metadata);
        $lines = Sale::getLines($id);
        foreach ($lines as $line) {
          $plan = DB::table('plans')->where("id", $line['plan'])->first();
          $line->plan = $plan->name;

          $equipment = DB::table('equipments')->where("id", $line['equipment'])->first();
          $line->equipment = $equipment->name;
        }
        $sale->lines = $lines;

        $commune = DB::table('communes')->where("id", $sale->delivery_commune)->first();
        $sale->delivery_commune = $commune->name;

        $initialDateTime = $sale->delivery_initial_time;
        $sale->delivery_initial_time  = date('H:i',strtotime($sale->delivery_initial_time));
        $sale->delivery_final_time    = date('H:i',strtotime($sale->delivery_final_time));
        $sale = json_decode(json_encode($sale), 1);//Si no hago esto, no puedo añadir nuevas propiedades
        $sale['delivery_date']        = date('Y-m-d',strtotime($initialDateTime));

        return SaleExport::exportPDF($sale);
    }

    public static function detailEdit(Request $request, $id){
      $data = $request->all();

      $sale = Sale::find($id);
      if (!$sale) return response()->json('Venta no encontrada', 404);

      if ($sale->metadata){
        $metadata = json_decode($sale->metadata);
        $metadata = (array) $metadata;
      }else {
        $metadata = [];
      }

      if ($sale->other_data){
        $other_data = json_decode($sale->other_data);
        $other_data = (array) $other_data;
      }else {
        $other_data = [];
      }

      $keysmetadata = [
        'meses',
        'cf',
        'cfa',
        'edad',
        'equipoarriendo',
        'montodeuda',
        'atraso'
      ];
      $keysother_data = [
        'lc',
        'simcard',
        'pcs',
        'diferencia_excepcionada',
        'descuento'
      ];


      foreach ($keysmetadata as $key)
        if (isset($data[$key])) $metadata[$key] = $data[$key];

      foreach ($keysother_data as $key)
        if (isset($data[$key])) $other_data[$key] = $data[$key];

      $excepciones = [
        0 => (isset($data['e0'])) ? true : false, //Límite de endeudamiento
        1 => (isset($data['e1'])) ? true : false, //Deuda claro
        2 => (isset($data['e2'])) ? true : false, //Meses de antigüedad (1-6)
        3 => (isset($data['e3'])) ? true : false, //Meses de antigüedad (1-13)
        4 => (isset($data['e4'])) ? true : false, //Edad
        5 => (isset($data['e5'])) ? true : false, //Cargo fijo
        6 => (isset($data['e6'])) ? true : false //Equipo en arriendo
      ];

      $other_data['excepciones'] = $excepciones;

      $metadata = json_encode($metadata);
      $other_data = json_encode($other_data);

      $toSave = [];
      $toSave['metadata'] = $metadata;
      $toSave['other_data'] = $other_data;

      $sale = $sale->update($toSave);
      if (!$sale) return response()->json('Error interno del servidor', 500);

      return response()->json('Editado Exitosamente', 200);
    }

    public function lines($id){
        $lines = Sale::getLines($id);
        return response()->json($lines, 200);
    }
}
