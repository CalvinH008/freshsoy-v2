@extends('layouts.app')
@section('content')
    <h2>edit category</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </div>
    @endif
    <form action=" {{ route('admin.categories.update', $category) }} " method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" placeholder="Nama" value="{{ old('name', $category->name) }}">
        <br>
        <textarea name="description" id="" cols="30" rows="10" placeholder="Description">{{ old('description', $category->description) }}</textarea>
        <br>
        <input type="checkbox" name="is_active" value="1"
            {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
        <label for="">Active</label>
        <br>
        <button type="submit">save</button>
    </form>
@endsection
