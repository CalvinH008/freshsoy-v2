@extends('layouts.app')
@section('content')
    <h2>Add Product</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </div>
    @endif
    <form action=" {{ route('admin.products.store') }} " method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <br>
        <input type="text" name="name" placeholder="Nama">
        <br>
        <input type="text" name="price" placeholder="Price">
        <br>
        <select name="category_id">
            <option value="" disabled selected>Choose Category</option>
            @foreach ($categories as $category)
                <option value=" {{ $category->id }} "> {{ $category->name }} </option>
            @endforeach
        </select>
        <textarea name="description" id="" cols="30" rows="10" placeholder="Description"></textarea>
        <br>
        <input type="checkbox" name="is_active" value="1" checked>
        <label for="">Active</label>
        <br>
        <button type="submit">add</button>
    </form>
@endsection
