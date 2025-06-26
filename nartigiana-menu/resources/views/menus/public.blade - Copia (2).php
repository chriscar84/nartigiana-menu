<x-app-layout>
    <x-slot name="header" class="bg-transparent">
        <div class="flex items-center space-x-4">
            @if($menu->logo)
                <img src="{{ asset('storage/' . $menu->logo) }}" alt="{{ $menu->title }} logo" class="h-12 w-12 rounded-md object-cover">
            @endif
            <h1 class="text-3xl font-extrabold text-orange-600 dark:text-orange-400">{{ $menu->title }}</h1>
        </div>
    </x-slot>

    {{-- Alpine.js per gestione collapsible --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body {
            background: url('/images/menu-bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .category-header {
            background-color: #FFEDD5;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.25rem;
            color: #C2410C;
            cursor: pointer;
            user-select: none;
        }
        .dish-card {
            display: flex;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            margin-bottom: 15px;
            padding: 15px;
            align-items: center;
            gap: 15px;
            transition: box-shadow 0.3s ease;
        }
        .dish-card:hover {
            box-shadow: 0 6px 16px rgb(0 0 0 / 0.15);
        }
        .dish-photo {
            flex-shrink: 0;
            width: 90px;
            height: 90px;
            border-radius: 10px;
            overflow: hidden;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dish-photo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .dish-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .dish-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #333;
        }
        .dish-desc {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 8px;
        }
        .dish-price {
            font-weight: 700;
            font-size: 1rem;
            color: #d97706;
            white-space: nowrap;
        }
        <!--
		.promo-banner {
            background: linear-gradient(90deg, #f97316 0%, #facc15 100%);
            color: white;
            text-align: center;
            padding: 15px;
            margin: 25px 0;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 4px 14px rgb(249 115 22 / 0.7);
        }
		-->
		.promo-banner {
			background-color: #fff7ed;
			border: 1px solid #f4e1d2;
			border-radius: 12px;
			overflow: hidden;
			margin: 1rem 0;
			box-shadow: 0 4px 12px rgba(0,0,0,0.08);
		}

		.promo-image {
			width: 100%;
			height: auto;
			display: block;
		}

		.promo-content {
			text-align: center;
			padding: 1rem;
		}

		.promo-logo {
			height: 50px;
			margin: 0.5rem auto;
		}

		.promo-content h3 {
			margin: 0;
			color: #e67e22;
			font-size: 1.4rem;
		}

		.promo-content p {
			margin: 0.3rem 0 0;
			color: #555;
			font-size: 0.95rem;
		}
		
        .category-icon {
            width: 28px;
            height: 28px;
            fill: #c2410c;
        }
        /* Freccia rotante */
        .arrow {
            transition: transform 0.3s ease;
            margin-left: auto;
            width: 20px;
            height: 20px;
            stroke: #c2410c;
        }
        .arrow.open {
            transform: rotate(90deg);
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 py-8">

        {{-- Categorie collapsible --}}
        @foreach ($menu->categories as $index => $category)
            <section x-data="{ open: false }" class="mt-4 mb-4">
                <button @click="open = !open" class="category-header w-full text-left flex items-center">
                    {{-- Icona categoria --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="category-icon" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12" y2="16" />
                    </svg>
                    <span class="ml-2">{{ $category->name }}</span>
                    {{-- Freccia --}}
                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'arrow open': open, 'arrow': !open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 6 15 12 9 18"></polyline>
                    </svg>
                </button>

                <div x-show="open" x-transition class="mt-3 space-y-3">
                    @foreach ($category->dishes as $dish)
                        <x-dish-card :dish="$dish" defImg="{{ asset('storage/' . $menu->logo) }}" />
                    @endforeach
                </div>
            </section>
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
</x-app-layout>
