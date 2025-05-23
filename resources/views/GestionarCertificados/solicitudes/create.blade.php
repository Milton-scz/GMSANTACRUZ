<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Crear Solicitud') }}
        </h2>
    </x-slot>

<div class="max-w-4xl mx-auto mt-8 bg-white shadow-md rounded-lg p-6">


        <form method="POST" action="{{ route('admin.solicitudes.store') }}">
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
                </div>

                <div class="text-center mt-6">
                    <button type="button" id="next"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded">
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
                        <input type="text" id="rubro" name="rubro" placeholder="Rubro"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="direccion_negocio" class="block text-sm font-medium text-gray-700">Dirección del Negocio</label>
                        <input type="text" id="direccion_negocio" name="direccion_negocio" placeholder="Dirección del negocio"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>
                     <div >
                    <label for="direccion" class="block text-sm font-medium text-gray-700">Ubicación en el Mapa</label>
                  <div id="map"></div>
                    <input type="hidden" id="lat" name="lat">
                    <input type="hidden" id="lng" name="lng">
                </div>

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
    <!-- Script para alternar pasos -->
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

        // Si todo está bien, pasar al siguiente paso
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

        // También puedes actualizar los valores al arrastrar el marcador manualmente
        marker.addListener('dragend', function (e) {
            document.getElementById('lat').value = e.latLng.lat();
            document.getElementById('lng').value = e.latLng.lng();
        });
    }
</script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjl2zf2HWN1idNXAIs0bQyBm0pOB4HiUA&callback=initMap" async defer></script>
</x-app-layout>
