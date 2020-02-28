<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Commune;
use App\Sale;
use App\State;
use App\Substate;
use Illuminate\Support\Facades\DB;
use App\Helpers\PHPClient\CurlHelper;

class ClientController extends Controller
{

    /* Movida al modelo
    public static function getPuntosRut( $rut , $noK = false ){
      $rut = str_replace('.','',$rut);//borro los puntos en caso de tenerlos
      $rutTmp = explode( "-", $rut );
      //En caso de no haber enviado ultimo digito o no conocerlo, se sustituye por K (o 0)
      $kDigit = (isset($rutTmp[1])) ? $rutTmp[1] : 'K';

      $toReturn = number_format($rutTmp[0], 0, "", ".") . '-' . $kDigit;

      if ($noK)
        $toReturn = number_format($rutTmp[0], 0, "", ".");

      return $toReturn;
    }*/

    public static function getPerson ( $rut ) {

      try {
        $rut = Client::getPuntosRut($rut);
        $reqCurl = new CurlHelper('https://www.nombrerutyfirma.com/rut');
        $result = $reqCurl->sPOST(['term' => $rut])->result;
        $namePos = strpos($result, '<tr tabindex="1">');
        if ($namePos) {
          $resultWithAfterNamePos = substr($result,$namePos,strlen($result));
          $finalInterestPos = strpos($resultWithAfterNamePos, '</tr>');
          $resultOnlyInterst = substr($resultWithAfterNamePos,1,$finalInterestPos-2);
          $resultOnlyInterst = str_replace(['tr tabindex="1">','<"','<td>',' style="white-space: nowrap;"','	','					',PHP_EOL],'',$resultOnlyInterst);
          $resultOnlyInterst = str_replace('<td>','',$resultOnlyInterst);
          $explodeData = explode('</td>',$resultOnlyInterst);
          $explodeName = explode(' ',$explodeData[0]);

          $lastName = null;
          $lastName2 = null;

          if (isset($explodeName[1]))
            $lastName = $explodeName[1];

          if (isset($explodeName[2]))
            $lastName2 = $explodeName[2];

          if (isset($explodeName[3]))
            $lastName2 .= ' '.$explodeName[3];

          /*
            if ($lastName2 && $explodeName[0]) {
              //intercambiar variables
            }
          */
          $comuna = null;
          $region = null;
          if (isset($explodeData[4]) && $explodeData[4]) {
            $explodeData[4] = substr($explodeData[4],1,strlen($explodeData[4]));
            $comunaOb = Commune::where('name','=',$explodeData[4])->first();
            //var_dump($comunaOb);exit();
            if ($comunaOb) {
              $comuna = $comunaOb->id;
              if ($comunaOb->region_id)
                $region = $comunaOb->region_id;
            }
          }

          $person = [
            //'fullName' => $explodeData[0],
            'name' => $explodeName[0],
            'last_name' => $lastName,
            'last_name_2' => $lastName2,
            'address' => isset($explodeData[3]) ? $explodeData[3] : null,
            'comuna' => $comuna,
            'region' => $region
          ];
          return $person;
        }
      } catch (\Exception $e) {
        return null;
      }

      return null;
    }

    public function findRut($rut) {

      if (!$rut) return response()->json('Peticion invalida', 401);

      $rut = str_replace('.','',$rut);//borro los puntos en caso de tenerlos

      $client = Client::where('rut','=',$rut)->first();

      if (!$client) $client = Client::where('rut','=',Client::getPuntosRut($rut))->first();
      if (!$client) $client = Client::where('rut','=',Client::getPuntosRut($rut, true))->first();

      $clientResponse = [
        'rut'  => null,
        'name' => null,
        'last_name' => null,
        'last_name_2' => null,
        'region' => null,
        'email' => null, //Esto no lo tiene el modelo de clientes... debe tenerlo
        'phone' => null,
        'address' => null,
        'carnet' => null,
        'birthday' => null,
        'comuna' => null,
        'carnet_expiration' => null,
        'active_sell' => null
      ];

      $encounter = null;

      if ($client) {
        $encounter = true;
        $active_sell = null;

        //Forma elegante
        $active_sell = Client::getActiveSell($client->id);

        if (!$active_sell) $active_sell = null;

        $clientResponse['rut'] = $client->rut;
        $clientResponse['name'] = $client->name;
        $clientResponse['last_name'] = $client->last_name;
        $clientResponse['last_name_2'] = $client->last_name_2;
        $clientResponse['phone'] = $client->phone;
        $clientResponse['address'] = $client->address;
        $clientResponse['carnet'] = $client->carnet;
        $clientResponse['birthday'] = $client->birthday;
        $clientResponse['carnet_expiration'] = $client->carnet_expiration;
        $clientResponse['active_sell'] = $active_sell;
        $clientResponse['comuna'] = $client->comuna;
        //$clientResponse['sells'] = $sells;
      }else{

        $person = ClientController::getPerson($rut);

        if ($person) {
          $encounter = true;

          $clientResponse['rut'] = $rut;

          if ($person['name'])
          $clientResponse['name'] = $person['name'];

          if ($person['last_name'])
          $clientResponse['last_name'] = $person['last_name'];

          if ($person['last_name_2'])
          $clientResponse['last_name_2'] = $person['last_name_2'];

          if ($person['address'])
          $clientResponse['address'] = $person['address'];

          if ($person['comuna'])
          $clientResponse['comuna'] = $person['comuna'];

          if ($person['region'])
          $clientResponse['region'] = $person['region'];
        }

      }

      if (!$encounter) return response()->json('Rut no encontrado o invalido', 404);

      return response()->json($clientResponse, 200);

    }

}
