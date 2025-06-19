@props(['disabled' => false])

<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' =>
            'border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm'
    ]) !!}>
    {{ $slot }}
</select>
