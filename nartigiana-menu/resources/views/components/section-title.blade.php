@props(['class' => ''])

<h2 {{ $attributes->merge(['class' => "text-2xl font-bold px-4 py-2 rounded-lg inline-flex items-center mb-6 $class"]) }}>
    {!! $icon ?? '' !!} {{ $slot }}
</h2>
