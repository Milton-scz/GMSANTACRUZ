<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.1/font/bootstrap-icons.css">
    <title>Gobernación Municipal de Santa Cruz</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

            body {
                margin: 0;
                padding: 0;
                background: #f0f2f5;
            }



        .banner {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 800px;
            background-image: url('{{ asset('bg.jpg') }}');
            background-size: cover;
            background-position: center;
            z-index: -1;
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
        }

        .card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 450px;
            text-align: center;
        }

        .card h2 {
            font-size: 1.7rem;
            color: #28a745;
            margin-bottom: 1rem;
        }

        .card p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .card-icon {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 1rem;
        }

        .card-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .card-button:hover {
            background-color: #218838;
        }

        .additional-images {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }

        .additional-images img {
            width: 80%;
            max-width: 400px;
            margin: 0.5rem 0;
        }

        .additional-images img:first-of-type {
        width: 40%;
        max-width: 200px;
        margin: 0.5rem 0;
    }
    .additional-images img:not(:first-of-type) {
        width: 80%;
        max-width: 400px;
        margin: 0.5rem 0;
    }
    .card-alert {
        background: red;
        font-size: bold;
    }
    .button-logout{
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.2rem 1rem;
    }
    .menu-drop{
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 0.2rem 0;
    }
    .menu-drop button{
        background-color: #28a745 !important;
    }
    .menu-drop button:hover{
        background-color: #218838 !important;
    }
    /* Asegura que el fondo ocupe todo el ancho */
/* Contenedor con fondo que ocupa la mitad superior de la pantalla */
.background-container {
    height: 50vh; /* 50% de la altura de la ventana */
    width: 100%;
    background-image: url('https://tramites-digitales.gmsantacruz.gob.bo/assets/images/blocks/hero/hero-2.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
}

/* Estilo de las imágenes encima del fondo */
.additional-images {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Centrado perfecto */
    z-index: 1;
    display: flex;
    gap: 20px;
}

.additional-images img {
    max-width: 200px;
    height: auto;
}
.card-clickable {
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.card-clickable:hover {
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}



    </style>
</head>
<body>


  <!-- Contenedor con imagen de fondo -->
<div class="background-container">
    <!-- Imágenes adicionales encima -->
    <div class="additional-images">
        <img src="https://tramites-digitales.gmsantacruz.gob.bo/assets/images/blocks/hero/logo_sc.png" alt="Imagen 1">
        <img src="https://tramites-digitales.gmsantacruz.gob.bo/assets/images/blocks/hero/logo_tramite.png" alt="Imagen 2">
    </div>
</div>










    @if(session('error'))
        <div class="card card-alert">
            <strong class="alert alert-danger">
                {{ session('error') }}
            </strong>
        </div>
    @endif

    <div class="container">
    <!-- Card 1: Licencia de Funcionamiento -->
                <div class="card card-clickable" onclick="window.location.href='/landing/tipos-licencias'">
                    <div class="card-icon"><i class="bi bi-file-earmark-text"></i></div>
                    <h2>Licencia de Funcionamiento</h2>
                    <p>Ingresa para iniciar los trámites de licencia de funcionamiento.</p>
                </div>


        <!-- Card 2: Consultas -->
        <div class="card">
            <div class="card-icon">&#x1F50D;</div> <!-- Icono de lupa en verde -->
            <h2>Consultas</h2>
            <p>Ingresa para consultar tus trámites, hacer seguimiento y verificar en qué estado se encuentran.</p>
            <div class="button-options">
                <button class="card-button" onclick="showCertificado()">Escanear Certificado</button>
                <button class="card-button bg-dark" data-bs-toggle="modal" data-bs-target="#tramiteModal">Seguimiento</button>
            </div>
        </div>

        <!-- Modal consulta -->
        <div class="modal fade" id="tramiteModal" tabindex="-1" aria-labelledby="tramiteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="tramiteModalLabel">Realizar seguimiento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="d-flex flex-column" id="licenciaForm" enctype="multipart/form-data">
                        <div class="mb-3">
                           <label for="codigoSolicitud" class="form-label">Introduzca codigo de solicitud (*)</label>
                           <input type="text" class="form-control py-2" id="codigoSolicitud" required>
                        </div>
                        <button id="sendButton" onclick="submitCodigo()" type="button" class="btn btn-primary w-100 py-lg-3 py-md-2 py-2 shadow-sm mt-4">
                           Consultar <i class="bi bi-check-circle-fill"></i>
                        </button>
                        <img id="loader" src="/images/loader.svg" alt="loader" width="70" style="margin: auto; display: none;"/>
                    </form>
                </div>
            </div>
            </div>
        </div>
<!-- Modal de resultado -->
<div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="resultadoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="resultadoModalLabel">Resultado de la consulta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="resultadoContenido">
        <!-- Aquí se cargará la respuesta -->
      </div>
    </div>
  </div>
</div>
<!-- Modal de escaneo QR -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="qrModalLabel">Escanear Código QR</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="stopScanner()" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="qr-reader" style="width:100%;"></div>
        <div class="mt-3 text-center" id="qr-result"></div>
      </div>
    </div>
  </div>
</div>

    </div>

<!-- Modal Validar Licencia -->
 @if(session('success'))
    <!-- Modal Bootstrap -->
    <div class="modal fade" id="modalSuccessLicencia" tabindex="-1" aria-labelledby="tramiteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tramiteModalLabel">Código de Seguimiento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="alert alert-success text-center fw-bold">
                        {{ session('success') }}
                    </p>

                </div>
            </div>
        </div>
    </div>

    <!-- Script para abrir el modal automáticamente -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tramiteModal = new bootstrap.Modal(document.getElementById('modalSuccessLicencia'));
            tramiteModal.show();
        });
    </script>
@endif



<script src="//unpkg.com/alpinejs" defer></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function submitCodigo() {
    const codigo = document.getElementById("codigoSolicitud").value.trim();
    const loader = document.getElementById("loader");
    const resultadoContenido = document.getElementById("resultadoContenido");

    if (!codigo) {
        alert("Por favor ingrese un código o cédula.");
        return;
    }

    loader.style.display = "block";

    fetch('/landing/seguimiento/consultar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ codigoSolicitud: codigo })
    })
    .then(response => response.json())
    .then(data => {
        loader.style.display = "none";
        // Cerrar modal de entrada
        const tramiteModal = bootstrap.Modal.getInstance(document.getElementById('tramiteModal'));
        tramiteModal.hide();
          //  console.log(data);
        // Mostrar resultado en el modal de resultados
        if (data.error) {
            resultadoContenido.innerHTML = `<p class="text-danger">${data.error}</p>`;
            const resultadoModal = new bootstrap.Modal(document.getElementById('resultadoModal'));
            resultadoModal.show();
            return;
        }
        if (data.estado == "PENDIENTE") {
            resultadoContenido.innerHTML = `<p class="text-warning">Su solicitud está pendiente de revisión.</p>`;
        } else if (data.estado == "APROBADA") {
            resultadoContenido.innerHTML = `
                <p><strong>Imprima el certificado desde el siguiente link:</strong>
                    <a href="/landing/certificados/descargar/${data.codigo}"
                    class="btn-descargar-certificado"
                    target="_blank" rel="noopener noreferrer">
                        📄 Imprimir Certificado
                    </a>
                </p>
            `;
        } else if (data.estado == "RECHAZADA") {
            resultadoContenido.innerHTML = `<p class="text-danger">${data.mensaje} Puede realizar nuevamente la solicitud.</p>`;

         } else if (data.estado == "NO FOUND") {
            resultadoContenido.innerHTML = `<p class="text-danger">No se encontró la solicitud.</p>`;
        }
        else {
            resultadoContenido.innerHTML = `<p class="text-info">Estado desconocido: ${data.estado}</p>`;
        }


        const resultadoModal = new bootstrap.Modal(document.getElementById('resultadoModal'));
        resultadoModal.show();
    })
    .catch(error => {
        loader.style.display = "none";
        resultadoContenido.innerHTML = `<p class="text-danger">Error al consultar. Intente nuevamente.</p>`;
        const resultadoModal = new bootstrap.Modal(document.getElementById('resultadoModal'));
        resultadoModal.show();
        console.error("Error:", error);
    });
}
</script>

<script>
let qrScanner;

function showCertificado() {
    const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
    qrModal.show();

    // Iniciar escáner QR
    setTimeout(() => {
        if (!qrScanner) {
            qrScanner = new Html5Qrcode("qr-reader");
        }

        qrScanner.start(
            { facingMode: "environment" }, // Cámara trasera
            {
                fps: 20,    // frames por segundo
                qrbox: 550  // área de escaneo
            },
            qrCodeMessage => {
                document.getElementById("qr-result").innerHTML = `
                  <p><strong>Imprima el certificado desde el siguiente link:</strong>
                    <a href="${qrCodeMessage}"
                    class="btn-descargar-certificado"
                    target="_blank" rel="noopener noreferrer">
                        📄 Imprimir Certificado
                    </a>
                </p>
                `;
                // Puedes hacer un fetch con ese valor o redirigir, por ejemplo:
                // window.location.href = `/landing/certificados/descargar/${qrCodeMessage}`;
                stopScanner();


            },
            errorMessage => {
                console.log(`Escaneo fallido: ${errorMessage}`);
            }
        ).catch(err => {
            document.getElementById("qr-result").innerHTML = `
                <div class="alert alert-danger">Error al acceder a la cámara: ${err}</div>
            `;
        });
    }, 300);
}
async function getCertificado(codigoSolicitud) {
    try {
        const url = `/landing/certificados/getCertificado/${encodeURIComponent(codigoSolicitud)}`;
        const response = await fetch(url);

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Error desconocido al consultar contrato');
        }

        const data = await response.json();
        console.log('Respuesta del contrato:', data);
        return data;
    } catch (error) {
        console.error('Error al obtener datos del contrato:', error.message);
        return { error: error.message };
    }
}

function stopScanner() {
    if (qrScanner) {
        qrScanner.stop().then(() => {
            qrScanner.clear();
        }).catch(err => {
            console.error("Error al detener el escáner", err);
        });
    }
}
</script>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

</body>
</html>
