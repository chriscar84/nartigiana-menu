@props(['title', 'subtitle', 'image', 'link'])

<div class="my-8">
    <a href="{{ $link }}" target="_blank" class="block rounded-xl overflow-hidden hover:scale-105 transition-transform duration-300">
        <!--
		<div class="relative h-48 md:h-64 bg-cover bg-center flex items-center justify-center text-center text-white" style="background-image: url('{{ $image }}');">
            <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
            <div class="relative z-10 px-4">
                <h2 class="text-2xl md:text-3xl font-bold">{{ $title }}</h2>
                <p class="text-sm md:text-base mt-2">{{ $subtitle }}</p>
            </div>
        </div>
		-->
		<div class="promo-banner mt-10 mb-10">
			<img src="{{ $image }}" alt="Birra N'Artigiana" class="promo-image">

			<div class="promo-content">
				<img src="{{ asset('images/logo-birra.png') }}" alt="Logo N'Artigiana" class="promo-logo">
				<h3 class="text-xl font-bold text-orange-600">{{ $title }}</h3>
				<p class="text-sm text-gray-600">{{ $subtitle }}</p>
			</div>
		</div>
    </a>
</div>




