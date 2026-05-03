@props(['name', 'label' => '', 'type' => 'text', 'value' => ''])
<div>
    @if ($label)
        <label for="{{$name}}" > {{$label}} </label>
    @endif
    <input type="{{$type}}" name="{{$name}}" value="{{$value}}" id="{{$name}}">
    @error($name)
        <span> {{ $message }} </span>
    @enderror
</div>
