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

                <form method="POST" enctype="multipart/form-data" action="{{ route('menus.update', $menu) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
						<x-input-label for="logo" :value="__('Logo del Ristorante')" />
						<x-input id="logo" class="mt-1 block w-full" type="file" name="logo" />
						@if($menu->logo)
                            <img src="{{ asset('storage/' . $menu->logo) }}" alt="Logo attuale" class="mt-2 w-32 rounded shadow">
                        @endif
						
						<x-input-error :messages="$errors->get('logo')" class="mt-2" />
					</div>
					
					<!-- Titolo -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Nome del Menù')" />
                        <x-text-input id="title" name="title" type="text"
                                      class="mt-1 block w-full"
                                      :value="old('title', $menu->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
					
					<div class="mb-4">
						<x-input-label class="block text-sm font-medium text-gray-700 dark:text-gray-300" :value="__('Url personalizzato')" />
						<x-text-input type="text" name="slug" id="slug"
							   value="{{ old('slug', $menu->slug) }}"
							   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white focus:ring-orange-500 focus:border-orange-500" />
						<small class="text-gray-500">Ad esempio: <code>pizzeria-da-gennaro</code></small>
					</div>
				
					<div class="mb-4">
						<x-input-label for="background_color" class="block font-medium text-gray-700" :value="__('Colore di Sfondo')" />
						<x-input type="color" name="background_color" id="background_color" 
							   value="{{ old('background_color', $menu->background_color ?? '#ff6600') }}"
							   class="mt-1 block w-16 h-10 p-0 border-none rounded cursor-pointer" />
					</div>

					<div class="mb-4">
						<x-input-label for="background_image" :value="__('Background')" />
						<x-input id="background_image" class="mt-1 block w-full" type="file" name="background_image" />
						@if($menu->background_image)
                            <img src="{{ asset('storage/' . $menu->background_image) }}" alt="Background" class="mt-2 w-32 rounded shadow" />
							<!-- Bottone per eliminare immagine di sfondo -->
							<button
								type="submit"
								name="delete_background_image"
								value="1"
								class="mt-2 inline-block px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
								onclick="return confirm('Sei sicuro di voler eliminare l\'immagine di sfondo?')"
							>
								Elimina immagine di sfondo
							</button>
                        @endif
						
						<x-input-error :messages="$errors->get('background_image')" class="mt-2" />
					</div>
					
					<div class="mb-4">
						<x-input-label for="primary_color" class="block font-medium text-gray-700" :value="__('Colore primario')" />
						<x-input type="color" name="primary_color" id="primary_color" 
							   value="{{ old('primary_color', $menu->primary_color ?? '#ff6600') }}"
							   class="mt-1 block w-16 h-10 p-0 border-none rounded cursor-pointer" />
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
