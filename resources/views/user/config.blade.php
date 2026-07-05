<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div>
                <x-input-label for="name" :value="__('Configuración de mi cuenta')" />
            </div>
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="Auth::user()->name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Surname -->
            <div>
                <x-input-label for="surname" :value="__('Surname')" />
                <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="Auth::user()->surname" required autofocus autocomplete="surname" />
                <x-input-error :messages="$errors->get('surname')" class="mt-2" />
            </div>
            <!-- Nick -->
            <div>
                <x-input-label for="nick" :value="__('Nick')" />
                <x-text-input id="nick" class="block mt-1 w-full" type="text" name="nick" :value="Auth::user()->nick" required autofocus autocomplete="nick" />
                <x-input-error :messages="$errors->get('nick')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="Auth::user()->email" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!-- Image -->
            <div class="mt-4">
                @if (Auth::user()->image)
                    <div class="mb-4">
                        <img src="{{ route('user.avatar', ['filename' => Auth::user()->image]) }}" alt="Avatar" class="w-20 h-20 rounded-full mx-auto">
                    </div>
                @endif
                <x-input-label for="image" :value="__('Avatar')" />
                <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"  autofocus autocomplete="image" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>


            <div class="flex items-center justify-end mt-4">

                <x-primary-button class="ms-4">
                    {{ __('Guardar cambios') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
