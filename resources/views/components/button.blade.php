@props(['type' => 'submit', 'variant' => 'primary'])
<button type=" {{ $type }} " class="button button-{{ $variant }} ">
    {{ $slot }}
</button>
