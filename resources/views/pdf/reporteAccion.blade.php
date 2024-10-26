<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Acción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        h3 {
            margin-top: 20px;
        }

        ul {
            list-style: none;
        }

        li {
            line-height: 1.6;
        }

        @page {
            footer: html_myfooter;
        }

        .imagen-accion {
            max-width: 100%;
            height: auto;
            margin: 1.25rem 6.875rem;
        }
    </style>
</head>

<body>
    <img src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents($imagePath)) }}" width="75px" height="75px">
    <h1>Reporte de Accion</h1>

    <p><strong>Fecha de Reporte:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    <p><strong>Generado por:</strong> {{ $usuario->nombre_usuario }} </p>

    <ul>
        <li><strong>Descripción:</strong> {{ $accion->descripcion }}</li>
        <li><strong>Fecha de Acción:</strong> {{ $accion->fecha_accion }}</li>
        <li><strong>Fecha de Cierre:</strong> {{ $accion->fecha_cierre }}</li>
        <li><strong>Estado:</strong> {{ $accion->estado }}</li>
        <li><strong>Incidencia Cerrada:</strong> {{ $accion->incidencia_name }}</li>
        <li><strong>Usuario:</strong> {{ $accion->usuario_name }}</li>
    </ul>

    @if ($accion->imagen)
        <div>
            <h3>Imágenes Relacionadas</h3>
        </div>

        <div>
            <img 
            src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/acciones/'.$accion->imagen))) }}" 
            alt="Imagen de la accion" 
            width="500px" 
            height="500px" 
            class="imagen-accion">
        </div>
    @endif

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 800, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>
    
</body>

</html>
