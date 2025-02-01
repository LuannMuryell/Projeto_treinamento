<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Property;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function syntheticPdf()
    {
        $properties = Property::with('contribuinte')->get();

        $pdf = Pdf::loadView('SyntheticReport', ['properties' => $properties]);
        
        return $pdf->stream('relatorio_imoveis.pdf');
    }

    public function analyticalPdf($ins_municipal)
    {
        $property = Property::with('contribuinte', 'averbacoes')->where('ins_municipal', $ins_municipal)->first();

        $pdf = Pdf::loadView('AnalyticalReport', ['property' => $property]);

        return $pdf->stream('informacoes_imovel{ins_municipal}.pdf');
    }
}
