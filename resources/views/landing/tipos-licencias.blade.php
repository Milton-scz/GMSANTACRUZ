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
            background: #f0f2f5;
        }

        .background-container {
            height: 50vh;
            width: 100%;
            background-image: url('https://tramites-digitales.gmsantacruz.gob.bo/assets/images/blocks/hero/hero-2.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
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

        .container {
            margin-top: 2rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .card:hover {
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .card-icon {
            font-size: 2.5rem;
            color: #28a745;
            flex-shrink: 0;
            margin-top: 0.2rem;
        }

        .card h2 {
            font-size: 1.4rem;
            color: #28a745;
            margin-bottom: 0.5rem;
            margin-top: 0;
        }

        .card p {
            font-size: 1rem;
            color: #333;
            margin: 0;
        }

        .card-text {
            flex: 1;
        }

        .card-alert {
            background: red;
            font-size: bold;
        }

    </style>


</head>
<body>

<!-- Imagen de fondo con logos -->
<div class="background-container">
    <!-- Imágenes adicionales encima -->
    <div class="additional-images">
        <img src="https://tramites-digitales.gmsantacruz.gob.bo/assets/images/blocks/hero/logo_sc.png" alt="Imagen 1">
        <img src="https://tramites-digitales.gmsantacruz.gob.bo/assets/images/blocks/hero/logo_tramite.png" alt="Imagen 2">
    </div>
</div>

<!-- Alertas de sesión -->
@if(session('error'))
    <div class="card card-alert">
        <strong class="alert alert-danger">
            {{ session('error') }}
        </strong>
    </div>
@endif

<!-- Tarjetas de trámites -->
<div class="container">
    <div class="row g-4 justify-content-center">

        <!-- SALUD -->
      <div class="col-md-6">
    <div class="card" onclick="window.location.href='{{ route('landing.solicitudes.create', ['rubro' => 'salud']) }}'">
        <div class="card-icon"><i class="bi bi-heart-pulse"></i></div>
        <div class="card-text">
            <h2>Licencia de Funcionamiento para el Servicio de Salud</h2>
            <p>Empadronamiento de licencia para farmacias, odontólogos, médicos, etc.</p>
        </div>
    </div>
</div>


        <!-- BEBIDAS -->
        <div class="col-md-6">
            <div class="card" onclick="window.location.href='{{ route('landing.solicitudes.create', ['rubro' => 'bebidas']) }}'">
                <div class="card-icon"><i class="bi-cup-straw"></i></div>
                <div class="card-text">
                    <h2>Licencia para expendio de Bebidas Alcohólicas</h2>
                    <p>Empadronamiento de bares, licorerías y actividades afines.</p>
                </div>
            </div>
        </div>

        <!-- COCA -->
        <div class="col-md-6">
             <div class="card" onclick="window.location.href='{{ route('landing.solicitudes.create', ['rubro' => 'coca']) }}'">
                <div class="card-icon"><i class="bi-flower1"></i></div>
                <div class="card-text">
                    <h2>Licencia para venta de Hoja de Coca</h2>
                    <p>Empadronamiento para venta específica de hoja de coca.</p>
                </div>
            </div>
        </div>

        <!-- COMIDA -->
        <div class="col-md-6">
             <div class="card" onclick="window.location.href='{{ route('landing.solicitudes.create', ['rubro' => 'comida']) }}'">
                <div class="card-icon"><i class="bi-egg-fried"></i></div>
                <div class="card-text">
                    <h2>Licencia para Servicio de Comida</h2>
                    <p>Empadronamiento de restaurantes, pensiones y servicios de alimentos.</p>
                </div>
            </div>
        </div>

        <!-- OPTICAS -->
        <div class="col-md-6">
            <div class="card" onclick="window.location.href='{{ route('landing.solicitudes.create', ['rubro' => 'optica']) }}'">
                <div class="card-icon"><i class="bi-eyeglasses"></i></div>
                <div class="card-text">
                    <h2>Licencia para Ópticas</h2>
                    <p>Empadronamiento de ópticas y servicios relacionados.</p>
                </div>
            </div>
        </div>

        <!-- OTROS -->
        <div class="col-md-6">
            <div class="card" onclick="window.location.href='{{ route('landing.solicitudes.create', ['rubro' => 'otros']) }}'">
                <div class="card-icon"><i class="bi-tools"></i></div>
                <div class="card-text">
                    <h2>Licencia para otros rubros</h2>
                    <p>Empadronamiento de talleres mecánicos, tiendas de barrio, etc.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Validar Licencia -->
 @if(session('success'))
    <!-- Modal Bootstrap -->
    <div class="modal fade" id="tramiteModal" tabindex="-1" aria-labelledby="tramiteModalLabel" aria-hidden="true">
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
            const tramiteModal = new bootstrap.Modal(document.getElementById('tramiteModal'));
            tramiteModal.show();
        });
    </script>
@endif



<script src="//unpkg.com/alpinejs" defer></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
