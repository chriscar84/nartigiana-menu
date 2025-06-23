<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crea Menù') }}
            </h2>
            <a href="{{ route('menus.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-400">
                &larr; Indietro
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

                <form method="POST" enctype="multipart/form-data" action="{{ route('menus.store') }}">
                    @csrf
					
					<div class="mb-4">
						<x-input-label for="logo" :value="__('Logo del Ristorante')" />
						<x-input id="logo" class="mt-1 block w-full" type="file" name="logo" />
						<x-input-error :messages="$errors->get('logo')" class="mt-2" />
					</div>
					
					<!-- Nome del Menù -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Nome del Menù')" />
                        <x-text-input id="title" name="title" type="text"
                                      class="mt-1 block w-full"
                                      :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Pulsante -->
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
