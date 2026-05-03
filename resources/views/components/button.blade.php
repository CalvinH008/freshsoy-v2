@props(['type' => 'submit', 'variant' => 'primary'])
@php
    $classes = match ($variant) {
        'primary' => 'bg-green-600 text-white hover:bg-green-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300',
        default => 'bg-green-600 text-white hover:bg-green-700',
    };
@endphp
<button type="{{ $type }}" class="px-4 py-2 rounded-lg font-medium text-sm transition {{ $classes }} ">
    {{ $slot }}
</button>
