@props(['dish','defImg'])

@php
    use Illuminate\Support\Facades\Storage;

    $imagePath = $dish->image && Storage::disk('public')->exists($dish->image)
        ? asset('storage/' . $dish->image)
        : $defImg;
@endphp

<div class="flex bg-white shadow rounded-lg overflow-hidden p-2 mb-1">
    <img 
        src="{{ $imagePath }}" 
        class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 object-cover flex-shrink-0" 
        alt="{{ $dish->name }}"
    />
    <div class="p-3 sm:p-4 flex flex-col justify-between flex-1 ml-1">
        <div>
            <h3 class="text-base sm:text-lg font-semibold text-gray-800">{{ $dish->name }}</h3>
            <p class="text-sm text-gray-600">{{ $dish->description }}</p>
        </div>
        <div class="text-right text-orange-600 font-bold mt-2 text-sm sm:text-base">
            € {{ number_format($dish->price, 2) }}
        </div>
    </div>
</div>
