@props(['type' => 'submit', 'variant' => 'primary', 'size' => 'md'])
@php
    $classes = match ($variant) {
        'primary' => 'bg-green-600 text-white hover:bg-green-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300',
        default => 'bg-green-600 text-white hover:bg-green-700',
    };
    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-1 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2 text-sm',
    };
@endphp
<button type="{{ $type }}" {{ $attributes }}
    class="rounded-lg font-medium transition {{$sizeClasses}} {{ $classes }} ">
    {{ $slot }}
</button>
