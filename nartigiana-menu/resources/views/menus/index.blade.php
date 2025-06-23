<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Menù') }}
            </h2>
			<a href="{{ route('menus.import.form') }}">
				<x-primary-button>Importa CSV</x-primary-button>
			</a>
            <a href="{{ route('menus.create') }}">
                <x-primary-button>+ Nuovo Menù</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ✅ Messaggio di successo -->
            @if (session('success'))
                <div class="mb-4 p-4 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <!-- 🔍 Filtro -->
            <form method="GET" action="{{ route('menus.index') }}" class="mt-6 mb-6">
                <div class="flex items-center space-x-2">
                    <x-text-input type="text" name="search" :value="request('search')" placeholder="Cerca per nome..." class="w-1/3" />
                    <x-primary-button>Filtra</x-primary-button>
                    <a href="{{ route('menus.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-400">
                        Reset
                    </a>
                </div>
            </form>

            <!-- 📋 Tabella -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full table-auto text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-2">Immagine</th>
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">Slug</th>
                                <th class="px-4 py-2 text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($menus as $menu)
                                <tr class="border-b border-gray-200 dark:border-gray-600">
                                    <td class="px-4 py-2">
										@if($menu->logo)
											<img src="{{ asset('storage/' . $menu->logo) }}" alt="{{ $menu->title }}" class="h-16 w-auto rounded">
										@else
											<span class="text-gray-400 italic">N/A</span>
										@endif
									</td>
									<td class="px-4 py-2">{{ $menu->title }}</td>
                                    <td class="px-4 py-2">{{ $menu->slug }}</td>
                                    <td class="px-4 py-2 text-right space-x-2">
                                        <a href="{{ route('menus.edit', $menu) }}" class="text-blue-500 hover:underline">Modifica</a>
                                        <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Sei sicuro di voler eliminare questo menù?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Elimina</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Nessun menù trovato.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- 📄 Paginazione -->
                    <div class="mt-6">
                        {{ $menus->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
