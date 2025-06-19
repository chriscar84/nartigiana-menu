<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Modifica Menù') }}
            </h2>
            <a href="{{ route('menus.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-400">
                &larr; Indietro
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

                <form method="POST" action="{{ route('menus.update', $menu) }}">
                    @csrf
                    @method('PUT')

                    <!-- Titolo -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Nome del Menù')" />
                        <x-text-input id="title" name="title" type="text"
                                      class="mt-1 block w-full"
                                      :value="old('title', $menu->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Pulsanti -->
                    <div class="flex justify-end mt-6">
                        <x-primary-button>
                            {{ __('Salva') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
