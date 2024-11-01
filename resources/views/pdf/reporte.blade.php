<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Incidencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        h3 {
            margin-top: 20px; /* Espacio entre h3 y la imagen */
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

        .imagen-incidencia {
            max-width: 100%;
            height: auto;
            margin: 1.25rem 6.875rem;
        }
    </style>
</head>

<body>
    <img src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents($imagePath)) }}" width="220px" height="75px">
    <h1>Reporte de Incidencia</h1>

    <p><strong>Fecha de Reporte:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    <p><strong>Generado por:</strong> {{ $usuario->nombre_usuario }} </p>

    <ul>
        <li><strong>Nombre:</strong> {{ $incidencia->nombre }}</li>
        <li><strong>Descripción:</strong> {{ $incidencia->descripcion }}</li>
        <li><strong>Estado:</strong> {{ $incidencia->estado_incidente_name }}</li>
        <li><strong>Fecha de Reporte:</strong> {{ $incidencia->fecha_reporte }}</li>
        <li><strong>Grado de Severidad:</strong> {{ $incidencia->severidad_name }}</li>
        <li><strong>Categoria:</strong> {{ $incidencia->categoria_name }}</li>
    </ul>

    @if ($incidencia->imagen) <!-- Asegúrate de que el campo imagen_url esté definido -->
        <div>
            <h3>Imágenes Relacionadas</h3>
        </div>

        <div>
            <img 
            src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/incidencias/'.$incidencia->imagen))) }}" 
            alt="Imagen de la incidencia" 
            width="500px" 
            height="500px" 
            class="imagen-incidencia">
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
