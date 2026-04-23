@extends('layouts.app')
@section('content')
    <h2>Add Category</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </div>
    @endif
    <form action=" {{ route('admin.categories.store') }} " method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nama">
        <br>
        <textarea name="description" id="" cols="30" rows="10" placeholder="Description"></textarea>
        <br>
        <input type="checkbox" name="is_active" value="1" checked>
        <label for="">Active</label>
        <br>
        <button type="submit">add</button>
    </form>
@endsection
