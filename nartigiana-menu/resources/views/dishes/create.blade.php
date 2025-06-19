<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crea Piatto') }}
            </h2>
            <a href="{{ route('dishes.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-400">
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

                <form action="{{ route('dishes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
					
					<div class="mb-4">
                        <x-input-label for="category_id" :value="__('Categoria')" />
                        <select id="category_id" name="category_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="" disabled selected>-- Seleziona una categoria --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nome Piatto')" />
                        <x-input id="name" name="name" type="text" required
                                 class="mt-1 block w-full"
                                 value="{{ old('name') }}" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Descrizione')" />
                        <textarea id="description" name="description" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white"
                                  required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Prezzo (€)')" />
                        <x-input id="price" name="price" type="number" step="0.01" min="0"
                                 class="mt-1 block w-full"
                                 value="{{ old('price') }}" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Immagine')" />
                        <x-input id="image" name="image" type="file"
                                 class="mt-1 block w-full" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Salva</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
