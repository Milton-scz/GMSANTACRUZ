<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CREAR USUARIO') }}
        </h2>
    </x-slot>

    <x-guest-layout>
        <form method="POST" action="{{ route('admin.users.register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Cedula -->
            <div class="mt-4">
                <x-input-label for="cedula" :value="__('Cédula')" />
                <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula')" required autocomplete="cedula" />
                <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
            </div>

            <!-- Celular -->
            <div class="mt-4">
                <x-input-label for="celular" :value="__('Celular')" />
                <x-text-input id="celular" class="block mt-1 w-full" type="text" name="celular" :value="old('celular')" required autocomplete="celular" />
                <x-input-error :messages="$errors->get('celular')" class="mt-2" />
            </div>

            <!-- Dirección -->
            <div class="mt-4">
                <x-input-label for="direccion" :value="__('Dirección')" />
                <x-text-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" :value="old('direccion')" required autocomplete="direccion" />
                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- New ComboBox Field -->
            <div class="mt-4">
                <x-input-label for="custom_field" :value="__('Seleccionar Rol')" />
                <select id="is_admin" name="is_admin" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="1">Administrador</option>
                    <option value="0">Cliente</option>
                </select>
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Registrar') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>
