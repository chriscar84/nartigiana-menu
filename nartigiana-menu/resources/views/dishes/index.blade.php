<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Piatti') }}
            </h2>
			<a href="{{ route('dishes.create') }}">
                <x-primary-button>+ Nuovo Piatto</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- 🔍 Filtro -->
            <form method="GET" action="{{ route('dishes.index') }}" class="mt-6 mb-6">
                <div class="flex items-center space-x-2">
                    <select name="category_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white focus:border-orange-400 focus:ring-orange-400">
						<option value="">Tutte le categorie</option>
						@foreach($categories as $category)
							<option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
								{{ $category->name }}
							</option>
						@endforeach
					</select>
					
					<input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cerca per nome..."
                           class="rounded border-gray-300 dark:bg-gray-700 dark:text-white focus:border-orange-400 focus:ring-orange-400">
                    
					
					<button type="submit"
                            class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Filtra
                    </button>
                    <a href="{{ route('dishes.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-400">
                        Reset
                    </a>
                </div>
            </form>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full table-auto text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-2">Immagine</th>
                                <th class="px-4 py-2">Categoria</th>
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">Prezzo</th>
                                <th class="px-4 py-2">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dishes as $dish)
                                <tr class="border-b border-gray-200 dark:border-gray-600">
                                    <td class="px-4 py-2">
										@if($dish->image)
											<img src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}" class="h-16 w-auto rounded">
										@else
											<span class="text-gray-400 italic">N/A</span>
										@endif
									</td>
									<td class="px-4 py-2">{{ $dish->category->name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $dish->name }}</td>
                                    <td class="px-4 py-2">{{ $dish->price }}</td>
                                    <td class="px-4 py-2 space-x-2">
										@if (!Str::contains(strtolower($dish->name), "n'artigiana"))
											<a href="{{ route('dishes.edit', $dish) }}" class="text-blue-500 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
		<path stroke-linecap="round" stroke-linejoin="round" d="M11 5h7m-7 0l-7 7v5a2 2 0 002 2h5l7-7M16 3l5 5-7 7-5-5 7-7z" />
	  </svg>
	  <span>Modifica</span></a>
											<form action="{{ route('dishes.destroy', $dish) }}" method="POST" class="inline"
												  onsubmit="return confirm('Sei sicuro di voler eliminare questo piatto?')">
												@csrf
												@method('DELETE')
												<button type="submit" class="text-red-500 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
		<path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
	  </svg>
	  <span>Elimina</span></button>
											</form>
										@endif
									</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">Nessun piatto trovato.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $dishes->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
