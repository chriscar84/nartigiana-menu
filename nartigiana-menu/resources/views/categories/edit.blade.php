<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Modifica Categoria') }}
            </h2>
            <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-400">
                &larr; Indietro
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

                @if ($errors->any())
                    <div class="mb-4 text-red-500">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nome Categoria')" />
                        <x-input id="name" name="name" type="text"
                                 value="{{ old('name', $category->name) }}"
                                 required
                                 class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
						<x-input-label for="menu_id" :value="__('Seleziona Menù')" />
						
						<select id="menu_id" name="menu_id" required
							class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
							
							<option value="" disabled>-- Scegli un menù --</option>
							@foreach($menus as $menu)
								<option value="{{ $menu->id }}" {{ old('menu_id', $category->menu_id) == $menu->id ? 'selected' : '' }}>
									{{ $menu->title }}
								</option>
							@endforeach
						</select>

						<x-input-error :messages="$errors->get('menu_id')" class="mt-2" />
					</div>


                    <div class="flex justify-end">
                        <x-primary-button>Salva</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
