@php
    $bgImage = $menu->background_image ? asset('storage/' . $menu->background_image) : null;
    $bgColor = $menu->background_color ?? '#ffffff';
    $primary = $menu->primary_color ?? '#ff6600';
@endphp

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>{{ $menu->title }}</title>
    @vite(['resources/css/app.css', 'resources/css/menu.css', 'resources/js/app.js'])
	@stack('styles')
</head>
<body style="background-image: url('{{ asset('storage/' . $menu->background_image) }}'); background-size: cover; background-position: center; background-attachment: fixed; background-color: {{ $bgColor }};" class="min-h-screen text-gray-900">
	<div class="max-w-4xl mx-auto px-4 py-8">
		<!-- Logo e Titolo -->
        <div class="flex items-center mb-8 gap-4">
            @if ($menu->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->logo))
                <img src="{{ asset('storage/' . $menu->logo) }}" alt="Logo" class="h-16 w-16 object-contain">
            @endif
            <h1 class="text-3xl font-bold">{{ $menu->title }}</h1>
        </div>

        <!-- Categorie -->
        @foreach ($menu->categories as $index => $category)
            <div x-data="{ open: false }" class="mb-6 bg-white shadow rounded-lg overflow-hidden">
                <button @click="open = !open"
                class="w-full text-left px-4 py-3 font-bold text-white flex items-center justify-between"
                style="background-color: {{ $primary }};">
					<span>{{ $category->name }}</span>
					<!-- Icona freccia -->
					<svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
					</svg>
				</button>

                <div x-show="open" x-collapse class="px-4 py-4 space-y-4 bg-gray-50">
                    @foreach ($category->dishes as $dish)
                        <x-dish-card :dish="$dish" defImg="{{ $menu->logo ? asset('storage/' . $menu->logo) : '' }}" />
                    @endforeach
                </div>
            </div>
			
			@if(($index + 1) % 4 == 0)
				<x-promo-banner
					title="Scopri N'Artigiana!"
					subtitle="La birra artigianale 100% Napoletana"
					image="{{ asset('images/banner-birra.png') }}"
					link="https://www.nartigiana.it"
				/>
			@endif
			
        @endforeach
    </div>
	<div class="text-center">
		<x-translate-widget />
	</div>
	
	@stack('scripts')
</body>
</html>
