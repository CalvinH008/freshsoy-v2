@extends('layouts.app')
@section('content')
    <h2>Edit product</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </div>
    @endif
    <form action=" {{ route('admin.products.update', $product) }} " method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" name="name" placeholder="Nama" value="{{ old('name', $product->name) }}">
        <br>
        <input type="text" name="price" placeholder="Price" value="{{ old('price', $product->price) }}">
        <br>
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" width="100">
        @endif
        <input type="file" name="image">
        <br>
        <select name="category_id" id="">
            <option value="" disabled selected>--Choose Category--</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <textarea name="description" id="" cols="30" rows="10" placeholder="Description">{{ old('description', $product->description) }}</textarea>
        <br>
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
        <label for="">Active</label>
        <br>
        <button type="submit">save</button>
    </form>
@endsection
