<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Revisar Solicitud') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 bg-white shadow-md rounded-lg p-6">
      <form method="POST" action="{{ route('admin.solicitudes.update', ['solicitud_id' => $solicitud->id]) }}" >
    @csrf
    @method('PATCH')


            <!-- Paso 1 -->
            <fieldset id="step1">
                <div class="text-center mb-6">
                    <p class="text-sm font-semibold text-blue-600">Paso 1 de 2</p>
                    <h2 class="text-lg font-bold text-gray-700">Datos del Solicitante</h2>
                </div>

                <!-- Tipo de Persona -->
                            <div class="flex space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="tipo_persona" value="natural"
                            {{ $solicitud->beneficiario->tipo_persona == 'natural' ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">Persona Natural</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="tipo_persona" value="juridica"
                            {{ $solicitud->beneficiario->tipo_persona == 'juridica' ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">Persona Jurídica</span>
                    </label>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="dto_nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                        <input type="text" id="dto_nombres" name="dto_nombres" value="{{ $solicitud->beneficiario->nombre }}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>

                    <div>
                        <label for="dto_cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                        <input type="number" id="dto_cedula" name="dto_cedula" value="{{ $solicitud->beneficiario->cedula}}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>

                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" id="direccion" name="direccion" value="{{ $solicitud->beneficiario->direccion }}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>

                    <div>
                        <label for="correo" class="block text-sm font-medium text-gray-700">E-mail</label>
                        <input type="email" id="correo" name="correo" value="{{ $solicitud->beneficiario->email }}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>

                    <div>
                        <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
                        <input type="number" id="celular" name="celular" value="{{ $solicitud->beneficiario->celular }}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>
                </div>

                <div class="text-center mt-6">
                    <button type="button" id="next" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded">
                        Siguiente
                    </button>
                </div>
            </fieldset>

            <!-- Paso 2 -->
            <fieldset id="step2" class="hidden">
                <div class="text-center mb-6">
                    <p class="text-sm font-semibold text-blue-600">Paso 2 de 2</p>
                    <h2 class="text-lg font-bold text-gray-700">Actividad Económica</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="actividad" class="block text-sm font-medium text-gray-700">Actividad Económica</label>
                        <input type="text" id="actividad" name="actividad" value="{{ $solicitud->formulario->actividadEconomica->actividad_economica }}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>

                      <div>
                        <label for="nit" class="block text-sm font-medium text-gray-700">Nit</label>
                        <input type="text" id="nit" name="nit" value="{{ $solicitud->formulario->actividadEconomica->nit }}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>

                    <div>
                        <label for="rubro" class="block text-sm font-medium text-gray-700">Rubro</label>
                        <input type="text" id="rubro" name="rubro" value="{{ $solicitud->formulario->actividadEconomica->rubro }}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="direccion_negocio" class="block text-sm font-medium text-gray-700">Dirección del Negocio</label>
                        <input type="text" id="direccion_negocio" name="direccion_negocio" value="{{ $solicitud->formulario->actividadEconomica->ubicacion }}" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm" />
                    </div>


                    <div class="md:col-span-2">
                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado de la Solicitud</label>
                        <select id="estado" name="estado" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm">
                            <option value="0" {{ $solicitud->estado == 0 ? 'selected' : '' }}>Pendiente</option>
                            <option value="1" {{ $solicitud->estado == 1 ? 'selected' : '' }}>Aprobada</option>
                            <option value="2" {{ $solicitud->estado == 2 ? 'selected' : '' }}>Rechazada</option>
                        </select>
                          <div id="motivoRechazoContainer" class="md:col-span-2 mt-4 hidden">
                            <label for="mensaje" class="block text-sm font-medium text-gray-700">Motivo del Rechazo</label>
                            <textarea id="mensaje" name="mensaje" rows="3" class="mt-1 p-2 w-full border border-gray-300 rounded-md text-sm"></textarea>
                        </div>

                    </div>
                    <!-- Ver Archivos Adjuntos -->
                   <div class="md:col-span-2 mt-4">
    <label class="block text-sm font-medium text-gray-700">Archivos Adjuntos</label>

    @if($solicitud->files && $solicitud->files->count())
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            @foreach($solicitud->files as $file)
                <div class="border rounded-md overflow-hidden shadow-sm w-full h-24 flex items-center justify-center">
                    <a href="https://gateway.pinata.cloud/ipfs/{{ $file->hash }}" target="_blank" class="w-full h-full flex items-center justify-center">
                        <img
                            src="https://gateway.pinata.cloud/ipfs/{{ $file->hash }}"
                            alt="{{ $file->nombre ?? 'Archivo IPFS' }}"
                            class="object-cover w-20 h-20"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                        >
                        <p class="hidden text-xs text-center text-gray-600 break-words px-1">
                            {{ $file->nombre ?? basename($file->hash) }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 mt-2">No hay archivos adjuntos.</p>
    @endif
</div>


                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ubicación en el Mapa</label>
                        <div id="map"></div>
                        <input type="hidden" id="lat" name="lat" value="{{ $solicitud->formulario->actividadEconomica->lat }}">
                        <input type="hidden" id="lng" name="lng" value="{{ $solicitud->formulario->actividadEconomica->lng}}">
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" id="prev" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium px-4 py-2 rounded">
                        Atrás
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded">
                        Guardar Cambios
                    </button>
                </div>
            </fieldset>
        </form>
    </div>

    <style>
        #map { height: 400px; width: 100%; }
    </style>
<script>
    const estadoSelect = document.getElementById('estado');
    const motivoContainer = document.getElementById('motivoRechazoContainer');

    function toggleMotivoRechazo() {
        if (estadoSelect.value === '2') { // Rechazada
            motivoContainer.classList.remove('hidden');
        } else {
            motivoContainer.classList.add('hidden');
        }
    }

    estadoSelect.addEventListener('change', toggleMotivoRechazo);

    // Ejecuta al cargar por si ya está seleccionada 'rechazada'
    window.addEventListener('DOMContentLoaded', toggleMotivoRechazo);
</script>

    <script>
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const nextBtn = document.getElementById('next');
        const prevBtn = document.getElementById('prev');

        nextBtn.addEventListener('click', () => {
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
            const initialLocation = {
                lat: parseFloat(document.getElementById('lat').value || -17.78629),
                lng: parseFloat(document.getElementById('lng').value || -63.18117)
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: initialLocation,
            });

            marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                draggable: true,
            });

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

            marker.addListener('dragend', function (e) {
                document.getElementById('lat').value = e.latLng.lat();
                document.getElementById('lng').value = e.latLng.lng();
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjl2zf2HWN1idNXAIs0bQyBm0pOB4HiUA&callback=initMap" async defer></script>
</x-app-layout>
