<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Formulario de Solicitudes</title>
    <!-- Incluir Tailwind CSS desde CDN -->
    <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
          @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
 <!-- NAV VERDE -->
<nav class="bg-green-600 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <h1 class="text-lg font-bold">
                Formulario de Solicitudes - rubro: {{ $rubro }}

            </h1>
        </div>
        <ul class="flex space-x-4 text-sm">
            <li><a href="#" class="hover:underline">Inicio</a></li>
            <li><a href="#" class="hover:underline">Ayuda</a></li>
            <li><a href="#" class="hover:underline">Contacto</a></li>
        </ul>
    </div>
</nav>

<div class="max-w-4xl mx-auto mt-8 bg-white shadow-md rounded-lg p-6">

    <form method="POST" action="{{ route('landing.solicitudes.store') }}" enctype="multipart/form-data">>
        @csrf

        <!-- Paso 1: Datos del solicitante -->
        <fieldset id="step1">
            <div class="text-center mb-6">
                <p class="text-sm font-semibold text-blue-600">Paso 1 de 2</p>
                <h2 class="text-lg font-bold text-gray-700">Datos del Solicitante</h2>
            </div>
            <!-- Tipo de Persona -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Persona</label>
                <div class="flex space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="tipo_persona" value="natural" class="text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Persona Natural</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="tipo_persona" value="juridica" class="text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Persona Jurídica</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="dto_nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                    <input type="text" id="dto_nombres" name="dto_nombres" placeholder="Nombres"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>

                <div>
                    <label for="dto_cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                    <input type="number" id="dto_cedula" name="dto_cedula" placeholder="Cédula de identidad"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>

                <div>
                    <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <input type="text" id="direccion" name="direccion" placeholder="Dirección"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>

                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" id="correo" name="correo" placeholder="Correo Electrónico"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>

                <div>
                    <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
                    <input type="number" id="celular" name="celular" placeholder="Celular"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>
                 <div class="mb-4">
                        <label for="cedula_anverso" class="block text-sm font-medium text-gray-700">Subir Cedula anverso</label>
                        <input type="file" id="cedula_anverso" name="cedula_anverso" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                 <div class="mb-4">
                        <label for="cedula_reverso" class="block text-sm font-medium text-gray-700">Subir Cedula reverso</label>
                        <input type="file" id="cedula_reverso" name="cedula_reverso" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
            </div>

            <div class="text-center mt-6">
                <button type="button" id="next"
                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded">
                    Siguiente
                </button>
            </div>
        </fieldset>

        <!-- Paso 2: Datos de la actividad económica -->
        <fieldset id="step2" class="hidden">
            <div class="text-center mb-6">
                <p class="text-sm font-semibold text-blue-600">Paso 2 de 2</p>
                <h2 class="text-lg font-bold text-gray-700">Actividad Económica</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="actividad" class="block text-sm font-medium text-gray-700">Actividad Económica</label>
                    <input type="text" id="actividad" name="actividad" placeholder="Actividad económica"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>
                <div>
                    <label for="nit" class="block text-sm font-medium text-gray-700">NIT</label>
                    <input type="text" id="nit" name="nit" placeholder="NIT"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>
                <div>
                    <label for="rubro" class="block text-sm font-medium text-gray-700">Rubro</label>
                    <input type="text" id="rubro" name="rubro" placeholder="Rubro"  value={{$rubro}} readonly
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>
<div>
                        <label for="lote" class="block text-sm font-medium text-gray-700">Lote</label>
                        <input type="text" id="lote" name="lote" placeholder="lote"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>
                     <div>
                        <label for="manzano" class="block text-sm font-medium text-gray-700">Manzano</label>
                        <input type="text" id="manzano" name="manzano" placeholder="manzano"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>
                     <div>
                        <label for="unidad_vecinal" class="block text-sm font-medium text-gray-700">Unidad Vecinal</label>
                        <input type="text" id="unidad_vecinal" name="unidad_vecinal" placeholder="unidad_vecinal"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>
                      <div>
                        <label for="distrito" class="block text-sm font-medium text-gray-700">Distrito</label>
                        <input type="text" id="distrito" name="distrito" placeholder="distrito"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>
                <div class="md:col-span-2">
                    <label for="direccion_negocio" class="block text-sm font-medium text-gray-700">Dirección del Negocio</label>
                    <input type="text" id="direccion_negocio" name="direccion_negocio" placeholder="Dirección del negocio"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                </div>
                <div>
                    <label for="direccion" class="block text-sm font-medium text-gray-700">Ubicación en el Mapa</label>
                    <div id="map"></div>
                    <input type="hidden" id="lat" name="lat" />
                    <input type="hidden" id="lng" name="lng" />
                </div>
            </div>
            <div class="mb-4">
                                    <label for="file_nit" class="block text-sm font-medium text-gray-700">Subir NIT</label>
                                    <input type="file" id="file_nit" name="file_nit" class="mt-1 p-2 w-full border rounded-md" required>
                            </div>
                            <div class="mb-4">
                                    <label for="file_luz" class="block text-sm font-medium text-gray-700">Subir Pre aviso de luz o Agua</label>
                                    <input type="file" id="file_luz" name="file_luz" class="mt-1 p-2 w-full border rounded-md" required>
                            </div>
            <div class="flex justify-between mt-6">
                <button type="button" id="prev"
                    class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium px-4 py-2 rounded">
                    Atrás
                </button>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded">
                    Enviar
                </button>
            </div>
        </fieldset>
    </form>
</div>
<style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
<!-- Scripts -->
<script>
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const nextBtn = document.getElementById('next');
    const prevBtn = document.getElementById('prev');

    nextBtn.addEventListener('click', () => {
        // Validar campos obligatorios del paso 1
        const tipoPersona = document.querySelector('input[name="tipo_persona"]:checked');
        const nombres = document.getElementById('dto_nombres').value.trim();
        const cedula = document.getElementById('dto_cedula').value.trim();
        const direccion = document.getElementById('direccion').value.trim();
        const correo = document.getElementById('correo').value.trim();
        const celular = document.getElementById('celular').value.trim();

        if (!tipoPersona || !nombres || !cedula || !direccion || !correo || !celular) {
            alert('Por favor, completa todos los campos del Paso 1 antes de continuar.');
            return;
        }

        step1.classList.add('hidden');
        step2.classList.remove('hidden');
    });

    prevBtn.addEventListener('click', () => {
        step2.classList.add('hidden');
        step1.classList.remove('hidden');
    });
</script>

<script>
    let map;
    let marker;

    function initMap() {
        const defaultLocation = { lat: -17.78629, lng: -63.18117 }; // Ubicación inicial

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: defaultLocation,
        });

        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
        });

        // Setear valores iniciales
        document.getElementById('lat').value = defaultLocation.lat;
        document.getElementById('lng').value = defaultLocation.lng;

        // Al hacer clic en el mapa, mover el marcador y actualizar los campos hidden
        map.addListener("click", function (e) {
            const clickedLocation = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };

            marker.setPosition(clickedLocation);
            map.panTo(clickedLocation);

            document.getElementById('lat').value = clickedLocation.lat;
            document.getElementById('lng').value = clickedLocation.lng;
        });

        // Actualizar valores al arrastrar marcador
        marker.addListener('dragend', function (e) {
            document.getElementById('lat').value = e.latLng.lat();
            document.getElementById('lng').value = e.latLng.lng();
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjl2zf2HWN1idNXAIs0bQyBm0pOB4HiUA&callback=initMap" async defer></script>

</body>
</html>
