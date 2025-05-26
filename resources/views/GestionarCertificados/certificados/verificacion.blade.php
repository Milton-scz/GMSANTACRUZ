<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('VERIFICAR CERTIFICADO') }}
    </h2>
  </x-slot>

  <x-guest-layout>
    <form id="formCertificado" enctype="multipart/form-data">
      @csrf
      <fieldset>
        <div class="mb-4">
          <label for="certificado" class="block text-sm font-medium text-gray-700">Subir Certificado</label>
          <input type="file" id="certificado" name="certificado" class="mt-1 p-2 w-full border rounded-md" required>
        </div>

        <button type="submit" class="next bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Subir
        </button>
      </fieldset>
    </form>

    <div id="resultado" class="mt-6"></div>
  </x-guest-layout>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <style>
    .datos {
      font-family: sans-serif;
      max-width: 600px;
      border: 1px solid #ccc;
      padding: 1rem;
      border-radius: 0.5rem;
      background-color: #f9f9f9;
    }

    .fila {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      border-bottom: 1px dashed #ddd;
      padding-bottom: 4px;
    }

    .etiqueta {
      font-weight: bold;
      color: #333;
      flex: 1;
    }

    .valor {
      flex: 2;
      color: #444;
    }
  </style>

  <script>
    const form = document.getElementById('formCertificado');
    const resultado = document.getElementById('resultado');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const fileInput = document.getElementById('certificado');
      if (fileInput.files.length === 0) {
        alert('Por favor selecciona un archivo.');
        return;
      }

      const formData = new FormData();
      formData.append('file', fileInput.files[0]);
      formData.append('language', 'spa');
      formData.append('isOverlayRequired', 'false');

      try {
        resultado.textContent = 'Procesando...';

        const response = await axios.post('https://api.ocr.space/parse/image', formData, {
          headers: {
            'apikey': 'helloworld',
            'Content-Type': 'multipart/form-data'
          }
        });

        const texto = response.data.ParsedResults[0].ParsedText;
        const lineas = texto
          .split('\n')
          .map(l => l.replace(/\r/g, '').trim())
          .filter(l => l !== '');

        const claves = [
          'Razón Social',
          'Propietario',
          'NIT / CI',
          'Actividad',
          'Dirección',
          'Superficie',
          'Fecha de Inicio',
          'Licencia N°'
        ];

        // Detectar inicio de valores
        const indiceValores = lineas.findIndex(linea =>
          linea.toLowerCase().includes('raul') ||
          /\d{5,}/.test(linea)
        );

        const valores = lineas.slice(indiceValores, indiceValores + claves.length);

        const datos = {};
        for (let i = 0; i < claves.length; i++) {
          datos[claves[i]] = valores[i] || '';
        }

        let html = '<div class="datos">';
        for (const [clave, valor] of Object.entries(datos)) {
          html += `
            <div class="fila">
              <span class="etiqueta">${clave}:</span>
              <span class="valor">${valor}</span>
            </div>`;
        }
        html += '</div>';
// Agregar botón de verificación al final
      html += `
        <div class="mt-4">
          <button id="verificarBtn" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Verificar Modificaciones
          </button>
        </div>
      `;
        resultado.innerHTML = html;

        let datosExtraidos = {};
        for (let i = 0; i < claves.length; i++) {
            datos[claves[i]] = valores[i] || '';
            }
            datosExtraidos = datos;
          // Escuchar el evento click del botón
      document.getElementById('verificarBtn').addEventListener('click', async () => {
                try {
                const respuesta = await axios.post('/admin/verificar/datos/firmados', datosExtraidos, {

                });

                alert(respuesta.data.mensaje);
            } catch (error) {
                console.error(error);
                alert('Error al verificar los datos.');
            }
      });

      } catch (error) {
        resultado.innerHTML = `<p class="text-red-500">Error al procesar la imagen: ${error}</p>`;
      }
    });
  </script>
</x-app-layout>
