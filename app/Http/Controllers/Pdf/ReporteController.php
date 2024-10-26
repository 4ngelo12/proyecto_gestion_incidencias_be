<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\AccionesModel;
use App\Models\IncidenciaModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Dompdf\Dompdf;
use Dompdf\Options;


class ReporteController extends Controller
{
    public function generarPDFIncidencia(string $idUsuario, string $id)
    {
        // Obtener la incidencia por ID
        $incidencia = IncidenciaModel::findOrFail($id);
        $usuario = UserModel::findOrFail($idUsuario);
        $imagePath = public_path('images/pdf/logo.png');

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Generar el PDF a partir de la vista 'pdf.reporte'
        $pdf = FacadePdf::loadView('pdf.reporte', compact('incidencia', 'usuario', 'imagePath'));

        // Descargar el PDF
        return $pdf->download('reporte_incidencia_' . $incidencia->id . '.pdf');
    }

    public function generarPDFAccion(string $idUsuario, string $id)
    {
        $accion = AccionesModel::findOrFail($id);
        $usuario = UserModel::findOrFail($idUsuario);
        $imagePath = public_path('images/pdf/logo.png');

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $pdf = FacadePdf::loadView('pdf.reporteAccion', compact('accion', 'usuario', 'imagePath'));

        return $pdf->download('reporte_accion_' . $accion->id . '.pdf');
    }
}
