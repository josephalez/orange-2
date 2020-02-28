<?php

namespace App\Exports;
use PDF;

class SaleExport
{

    public static function exportPDF($sale)
    {
      $pdf = PDF::loadView('SalePDF', (array) $sale);
      return $pdf->download('Reporte Orange #' . $sale['id'] . '.pdf');
    }
}
