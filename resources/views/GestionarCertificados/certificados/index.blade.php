

<x-app-layout>
    <x-slot name="header" class="mt-6">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('GESTIONAR CERTIFICADOS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <section id="contenido_principal">
                    <div class="col-md-12" style="margin-top: 10px;">

                    </div>

                        <div class="col-md-12">
                            <div class="box box-default" style="border: 1px solid #0c0c0c;">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="padding: 10px;">
    <div style="height: 100%; overflow: auto;">
        <table class="table table-bordered table-condensed table-striped" id="tabla-empresas" style="width: 100%;">
            <!-- Encabezados de la tabla -->
            <thead>
                <th colspan="5"></th>
            </thead>
            <thead style="background-color: #dff1ff;">

                <th style="text-align: center;">Nro de solicitud</th>
                <th style="text-align: center;">Beneficiario</th>
                 <th style="text-align: center;">Signed</th>
                <th style="text-align: center;">Acción</th>
            </thead>
            @foreach($certificados as $certificado)

                <tr>
                        <td style="text-align: center;">{{$certificado->solicitud->id}}</td>
                        <td style="text-align: center;">{{$certificado->solicitud->beneficiario->nombre}}</td>
                        <td style="text-align: center; font-weight: bold; color: {{ $certificado->signed ? '#1e6932' : '#c0392b' }};">
                            {{ $certificado->signed ? 'Firmado' : 'No firmado' }}
                        </td>





               <td style="text-align: center;">
                        <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">


                             <a href="{{ route('admin.certificados.descargar', $certificado->solicitud->id) }}"
                            class="btn-descargar-certificado"
                            target="_blank" rel="noopener noreferrer">
                                📄 Imprmir Certificado
                            </a>
                            <a href="{{ route('admin.certificados.ver', $certificado->solicitud->id) }}"
                            target="_blank"
                            class="btn-descargar-certificado">
                            📄 Ver PDF Firmado
                            </a>

                            <button class="btn-firmar-certificado"
                                    data-id="{{ $certificado->solicitud->id }}">
                                ✍️ Firmar
                            </button>

                        </div>
                    </td>


                </tr>

             @endforeach
            </tbody>
         </table>
        </div>
        </div>
        <div class="my-4">
           {{$certificados->links()}}
        </div>
                            </div>
                        </div>
                </section>
                </div>
            </div>
    </div>
 </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const botonesFirmar = document.querySelectorAll('.btn-firmar-certificado');

    botonesFirmar.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault(); // Evita recarga

            const certificadoId = this.dataset.id;

            fetch(`/admin-certificados/firmarPdf/${certificadoId}`, {
                method: 'GET', // o 'POST' si así está tu ruta
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Certificado firmado correctamente.\n' + data.message);
                    location.reload(); // Si querés actualizar tabla después
                } else {
                    alert('❌ Error al firmar: ' + (data.message || 'Error desconocido.'));
                }
            })
            .catch(error => {
                console.error(error);
                alert('❌ Error inesperado al firmar el certificado.');
            });
        });
    });
});
</script>

</x-app-layout>
<!--MODAL PARA ELIMINAR-->


<style>
    .btn-descargar-certificado {
        background-color: #1e6932; /* Verde institucional */
        color: white;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: inline-block;
    }

    .btn-descargar-certificado:hover {
        background-color: #145324;
        transform: scale(1.03);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }
</style>
