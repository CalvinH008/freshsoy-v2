@props(['name', 'label' => '', 'type' => 'text', 'value' => ''])
<div>
    @if ($label)
        <label for=""> {{$label}} </label>
    @endif
    <input type=" {{$type}} " name=" {{$name}} " value="{{$value}} ">
    @error($name)
        <span> {{ $message }} </span>
    @enderror
</div>
