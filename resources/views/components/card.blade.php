@props(['padding' => true])
<div class="card bg-white rounded-2xl shadow overflow-hidden {{$padding ? 'p-5' : ''}} " >
    {{ $slot }}
</div>
