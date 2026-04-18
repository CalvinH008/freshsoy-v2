@extends('layouts.app')
@section('content')
    <h2>edit outlet</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </div>
    @endif
    <form action=" {{ route('admin.outlets.update', $outlet) }} " method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" placeholder="Nama" value=" {{old('name', $outlet->name)}} ">
        <br>
        <input type="text" name="code" placeholder="Code" value=" {{old('code', $outlet->code)}} ">
        <br>
        <input type="text" name="address" placeholder="Address" value=" {{old('address', $outlet->address)}} ">
        <br>
        <input type="text" name="phone" placeholder="Phone Number" value=" {{old('phone', $outlet->phone)}} ">
        <br>
        <input type="checkbox" name="is_active" value="1" {{old('is_active', $outlet->is_active) ? 'checked' : ''}} >
        <br>
        <button type="submit">save</button>
    </form>
@endsection
