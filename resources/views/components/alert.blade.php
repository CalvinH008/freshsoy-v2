@props(['type' => 'success', 'message' => ''])
@php
    $classes = match ($type) {
        'success' => 'bg-green-50 border border-green-200 text-green-700',
        'error' => 'bg-red-50 border border-red-200 text-red-700',
        'warning' => 'bg-yellow-50 border border-yellow-200 text-yellow-700',
        default => 'bg-gray-50 border border-gray-200 text-gray-700',
    };
@endphp

<div class="px-4 py-3 rounded-lg {{ $classes }}">
    {{ $message }}
</div>
