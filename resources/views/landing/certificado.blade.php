<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Licencia de Funcionamiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #fff;
            color: #000;
        }
        .marco {
            border: 10px solid #1e6932;
            padding: 30px;
            position: relative; /* Necesario para posicionar el QR */
            max-width: 800px;
            margin: auto;
            background: white;
        }
        .encabezado {
            text-align: center;
            border-bottom: 2px solid #1e6932;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .titulo {
            font-size: 20px;
            font-weight: bold;
            color: #1e6932;
            margin-top: 10px;
        }
        .subtitulo {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
       .datos {
  margin-top: 20px;
  font-family: Arial, sans-serif;
}

.fila {
  display: flex;
  justify-content: flex-start;
  gap: 10px;
  margin-bottom: 6px;
}

.etiqueta {
  font-weight: bold;
  width: 180px;
  color: #333;
}

.valor {
  color: #000;
}

        .observacion {
            font-size: 12px;
            color: #333;
            margin-top: 20px;
        }
        .pie {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #000;
            font-weight: bold;
            border-top: 2px solid #1e6932;
            padding-top: 10px;
        }
        .qr {
            position: absolute;
            bottom: 30px;
            right: 30px;
            width: 200px;
            height: 200px;
        }
        #downloadBtn {
            display: block;
            margin: 20px auto;
            padding: 10px 25px;
            font-size: 16px;
            background-color: #1e6932;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #downloadBtn:hover {
            background-color: #145219;
        }
        @media print {
        body * {
            visibility: hidden;
        }
        #licencia, #licencia * {
            visibility: visible;
        }
        #licencia {
            position: relative;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
         @page {
            size: landscape;
        }
    }
    </style>
</head>
<body>
    <div class="marco" id="licencia">
        <div class="encabezado">
            <div class="titulo">GOBIERNO AUTÓNOMO MUNICIPAL DE SANTA CRUZ DE LA SIERRA</div>
            <div>SECRETARÍA MUNICIPAL DE ADMINISTRACIÓN TRIBUTARIA</div>
            <div class="subtitulo">LICENCIA DE FUNCIONAMIENTO DE ACTIVIDAD ECONÓMICA</div>
        </div>

        <div class="datos">
            <div class="fila"><span class="etiqueta">Razón Social:</span> {{ $data['nombre'] }}</div>
            <div class="fila"><span class="etiqueta">Propietario:</span> {{ $data['nombre'] }}</div>
            <div class="fila"><span class="etiqueta">NIT / CI:</span> {{ $data['nit'] }}</div>
            <div class="fila"><span class="etiqueta">Actividad:</span> {{ $data['actividad'] }}</div>
            <div class="fila"><span class="etiqueta">Dirección:</span>{{ $data['direccion'] }}</div>
            <div class="fila"><span class="etiqueta">Fecha de Inicio:</span>{{ $data['fecha'] }}</div>
            <div class="fila"><span class="etiqueta">Licencia N°:</span> {{ $data['id'] }}</div>
        </div>

        <div class="observacion">
            El monto fijado a la patente municipal será actualizado de acuerdo al mantenimiento de valor.<br>
            Cualquier contravención a lo establecido en el código de urbanismo y obras, deja sin efecto esta licencia.
        </div>

        <div class="pie">
            Esta licencia deberá ser colocada en lugar visible.
        </div>

        <img
            src="https://quickchart.io/qr?text={{ urlencode('/landing/certificados/descargar/' . $data['id']) }}&dark=000000&light=ffffff&ecLevel=Q&format=png"
            alt="QR Code"
            class="qr"
            />


       <div style="margin-top: 40px; border-top: 1px solid #1e6932; padding-top: 10px;">
    <div style="font-size: 12px;">Fecha de firma: {{ $data['fecha'] }}</div>
      <div style="margin-top: 10px; font-size: 14px; font-weight: bold;">Firma Digital:</div>
    <div style="font-size: 10px; margin-top: 5px; font-weight: bold;">

        <code style="word-wrap: break-word; word-break: break-all;">
            {{ $data['firma'] }}
        </code>
    </div>
</div>

    </div>
 <div class="no-print" style="text-align: center; margin-top: 40px;">
    <button onclick="printLabel()" id="downloadBtn">📄 Imprimir Certificado</button>
</div>



    <!-- Importar jsPDF y html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        function printLabel() {
            window.print();
        }
    </script>
</body>
</html>
