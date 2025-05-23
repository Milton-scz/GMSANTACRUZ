

<x-app-layout>
    <x-slot name="header" class="mt-6">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('GESTIONAR SOLICITUDES') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <section id="contenido_principal">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="box box-default" style="border: 1px solid #574B90; min-height: 35px;">
                            <a href="{{ route('admin.solicitudes.create') }}" class="btn btn-success" style="font-size: 13px; margin-top: 5px; margin-left: 5px;"> Agregar </a>

                        </div>
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
                <th style="text-align: center;">Codigo de solicitud</th>
                <th style="text-align: center;">Nro de formulario</th>
                 <th style="text-align: center;">Beneficiario</th>
                <th style="text-align: center;">estado</th>
                <th style="text-align: center;">Acción</th>
            </thead>
            @foreach($solicitudes as $solicitud)

                <tr>
                        <td style="text-align: center;">{{$solicitud->id}}</td>
                         <td style="text-align: center;">{{$solicitud->formulario_id}}</td>
                           <td style="text-align: center;">{{$solicitud->beneficiario->nombre}}</td>
                              <td style="text-align: center;">
                                    @php
                                        switch($solicitud->estado) {
                                            case 0:
                                                $color = 'orange';
                                                $text = 'Pendiente';
                                                break;
                                            case 1:
                                                $color = 'green';
                                                $text = 'Aprobado';
                                                break;
                                            case 2:
                                                $color = 'red';
                                                $text = 'Rechazado';
                                                break;
                                            default:
                                                $color = 'gray';
                                                $text = 'Desconocido';
                                        }
                                    @endphp
                                    <span style="color: {{ $color }}; font-weight: bold;">
                                        {{ $text }}
                                    </span>
                                </td>

                        <td style="text-align: center;">
                            <x-custom-button :url="'admin-solicitudes/edit/'" :valor="$solicitud" >{{ __('Revisar') }}</x-custom-button>
                            <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal','{{$solicitud->id}}')">{{ __('Eliminar') }}</x-danger-button>
                            <x-modal name='{{$solicitud->id}}' :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form method="POST" action="{{ route('admin.solicitudes.delete', ['solicitud_id' => $solicitud->id]) }}" class="p-6">

                       @method('DELETE')

                      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('¿Estás seguro que deseas eliminar la solicitud') }}{{ $solicitud->id }}{{ __('?') }}
                      </h2>

                      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                         {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                      </p>

                          <div class="mt-6 flex justify-end">
                          <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                          </x-secondary-button>

                          <x-danger-button class="ms-3">
                    {{ __('Eliminar Solicitud') }}
                      </x-danger-button>
                             </div>
                  </form>
                </x-modal>
                    </td>
                </tr>

             @endforeach
            </tbody>
         </table>
        </div>
        </div>
        <div class="my-4">
           {{$solicitudes->links()}}
        </div>
                            </div>
                        </div>
                </section>
                </div>
            </div>
    </div>
 </div>

</x-app-layout>
<!--MODAL PARA ELIMINAR-->



