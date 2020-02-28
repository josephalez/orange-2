<?php

namespace App\Imports;

use App\Stock;
use App\equipment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class StockImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder, ToModel, WithHeadingRow
//implements ToModel, WithHeadingRow, WithCustomValueBinder
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    /*public function bindValue(Cell $cell, $value)
    {
        var_dump($cell);
        var_dump($value);
        exit();
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }*/

    public function model(array $row)
    {
        //var_dump($row);echo '<br><br><br><br><br><br>';

        //if (!isset($row['modelo'])) exit();
        if (!isset($row['modelo'])) return null;
        //has
          //modifico para que sea vacio
        //else
          //inicializo vacio

        $equipment = equipment::where('code','=',$row['modelo'])->first();

        if (!$equipment) {
            $equipment = equipment::where('name','=',$row['modelo'])->first();
            if (!$equipment) {
                $equipment = equipment::createEquipment([
                    'code' => $row['modelo'],
                    'name' => isset($row['nombre']) ? $row['nombre'] : $row['modelo'],
                    'mark' => isset($row['marca']) ? $row['marca'] : null,

                ]);
            }
        }
        if (!isset($row['imei'])) return null;
        $row['imei'] = (string) $row['imei'];

        if ( session('imeiCut') ){
          $row['imei'] = substr($row['imei'], 3);
        }
            $jsonExcel = session('jsonExcel');
            $jsonExcel[] = [
              'imei' => $row['imei'],
              'equipo' => $row['modelo'],
              'marca' => $row['marca'],
              'guia' => isset($row['guia_de_despacho_n0']) ? $row['guia_de_despacho_n0'] : '',
              'sku' => isset($row['sku']) ? $row['sku'] : '',
              'color' => isset($row['color']) ? $row['color'] : '',
            ];
            session(['jsonExcel'=>$jsonExcel]);


            $stock = stock::where('imei','=',$row['imei'])->first();
            if ($stock) return null;
            return new Stock([
                'imei' => $row['imei'],
                // 'sim',
                'equipment' => $equipment->id,
                // 'lost',
                // 'line',
                'office_guide' => isset($row['guia_de_despacho_n0']) ? $row['guia_de_despacho_n0'] : null,
                'sku' => isset($row['sku']) ? $row['sku'] : null,
                'color' => isset($row['color']) ? $row['color'] : null
            ]);
    }
}
