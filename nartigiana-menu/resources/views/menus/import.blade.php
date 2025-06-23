<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Importa Menu da CSV') }}
        </h2>
    </x-slot>

    <div class="py-8">
	
        <div class="max-w-xl mx-auto">
		
			<div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 dark:bg-yellow-200 dark:text-yellow-900 rounded">
				<strong>Attenzione:</strong> tutti i piatti e le categorie esistenti collegati al menù selezionato verranno <strong>eliminati</strong> prima dell'importazione del nuovo file.
			</div>
			
            <form method="POST" action="{{ route('menus.import') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                @csrf

                <div class="mb-4">
                    <x-label for="menu_id" :value="'Seleziona Menù'" />
                    <select name="menu_id" id="menu_id" required class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <x-label for="file" :value="'File CSV'" />
                    <x-input id="file" type="file" name="file" required class="mt-1 block w-full" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>Importa</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
