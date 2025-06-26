<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>{{ $menu->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('{{ asset('images/menu-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
        }

        .overlay {
            background-color: rgba(255, 255, 255, 0.88);
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .menu-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .menu-header img {
            height: 60px;
            width: auto;
        }

        .menu-header h1 {
            font-size: 2rem;
            color: #e67e22;
            margin: 0;
        }

        .category {
            margin-bottom: 2.5rem;
        }

        .category-title {
            background-color: #e67e22;
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .dish-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 1rem;
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .dish-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .dish-info {
            flex: 1;
        }

        .dish-name {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
            color: #222;
        }

        .dish-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.3rem;
        }

        .dish-price {
            font-size: 1rem;
            color: #e67e22;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .dish-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .dish-image {
                width: 100%;
                height: auto;
            }

            .dish-info {
                width: 100%;
            }

            .menu-header {
                flex-direction: column;
                gap: 0.5rem;
            }

            .menu-header h1 {
                font-size: 1.5rem;
            }
        }
		
		.promo-banner {
			background-color: #fff7ed;
			border: 1px solid #f4e1d2;
			border-radius: 12px;
			overflow: hidden;
			margin: 2rem 0;
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
			margin-bottom: 0.5rem;
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

    </style>
</head>
<body>
    <div class="overlay">
        <div class="menu-header">
            @if($menu->logo)
                <img src="{{ asset('storage/' . $menu->logo) }}" alt="Logo {{ $menu->title }}">
            @endif
            <h1>{{ $menu->title }}</h1>
        </div>

        @foreach($menu->categories as $index => $category)
            
			<div class="category">
                <div class="category-title">{{ $category->name }}</div>

                @foreach($category->dishes as $dish)
                    <div class="dish-card">
                        @if($dish->image)
                            <img src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}" class="dish-image">
                        @endif
                        <div class="dish-info">
                            <div class="dish-name">{{ $dish->name }}</div>
                            @if($dish->description)
                                <div class="dish-description">{{ $dish->description }}</div>
                            @endif
                            <div class="dish-price">€ {{ number_format($dish->price, 2, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
			
			@if(($index + 1) % 2 == 0)
				@include('partials.banner-birra')
			@endif

        @endforeach
    </div>
</body>
</html>
