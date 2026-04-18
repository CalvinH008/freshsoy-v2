@extends('layouts.app')
@section('content')
    <h2>add outlet</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </div>
    @endif
    <form action=" {{ route('admin.outlets.store') }} " method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nama">
        <br>
        <input type="text" name="code" placeholder="Code">
        <br>
        <input type="text" name="address" placeholder="Address">
        <br>
        <input type="text" name="phone" placeholder="Phone Number">
        <br>
        <input type="checkbox" name="is_active" value="1" checked>
        <label for="">aktif</label>
        <br>
        <button type="submit">add</button> 
    </form>
@endsection
