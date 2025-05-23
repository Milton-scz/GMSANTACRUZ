<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CREAR USUARIO') }}
        </h2>
    </x-slot>

    <x-guest-layout>
        <form method="POST" action="{{ route('admin.users.register') }}">
            @csrf

            <fieldset>
                        <h2 class="text-xl font-semibold mb-4">Paso 1: Registra al Cliente</h2>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombres</label>
                            <input type="text" id="name" name="dto_nombres" placeholder="Nombres"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="cedula" class="block text-sm font-medium text-gray-700">Cedula</label>
                            <input type="number" id="cedula" name="dto_cedula" placeholder="Cedula de identidad"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>


                        <div class="mb-4">
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Direccion</label>
                            <input type="text" id="direccion" name="direccion" placeholder="Direccion"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="correo" class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="text" id="correo" name="correo" placeholder="Correo Electronico"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
                            <input type="number" id="celular" name="celular" placeholder="Celular"
                                class="mt-1 p-2 w-full border rounded-md">
                        </div>

                        <button type="button" name="next"
                            class="next bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Siguiente
                        </button>
                    </fieldset>
        </form>
    </x-guest-layout>
</x-app-layout>
