<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('EDITAR USUARIO') }}
        </h2>
    </x-slot>

    <x-guest-layout>
    <form method="POST" action="{{ route('admin.users.update', ['user_id' => $user->id]) }}" >
    @csrf
    @method('PATCH')
    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
    <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- New ComboBox Field -->
    <div class="mt-4">
        <x-input-label for="custom_field" :value="__('Seleccionar Rol')" />
        <div class="mt-4">

      <select id="is_admin" name="is_admin" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
       @if($user->is_admin === 1)
            <option value= "1"  selected>Administrador</option>
             <option value="0">Estudiante</option>
            @else
            <option value="1">Administrador</option>
            <option value="0" selected>Cliente</option>

        @endif
      </select>
      </div>
        <!-- You can modify the options and values accordingly -->
    </div>

    <div class="flex items-center justify-center mt-4">
        <x-primary-button class="ms-4">
            {{ __('Actualizar') }}
        </x-primary-button>
    </div>
</form>

</x-guest-layout>

</x-app-layout>
