@extends('layouts.app')
@section('content')
    <h2>Product Management</h2>
    <form action=" {{ route('admin.products.index') }} " method="GET">
        <input type="search" name="search" value=" {{ request('search') }} " placeholder="Find Products">
        <select name="is_active">
            <option value="" disabled selected>Status</option>
            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" name="sort">Sort</button>
        <a href="{{ route('admin.products.index') }}">Reset</a>
    </form>

    <a href=" {{ route('admin.products.create') }} ">Add Products</a>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Category</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" width="50">
                        @endif
                    </td>
                    <td> {{ $product->category->name }} </td>
                    <td> {{ $product->name }} </td>
                    <td> {{ $product->price }} </td>
                    <td> {{ $product->description }} </td>
                    <td>
                        <a href=" {{ route('admin.products.edit', $product) }} ">edit</a>
                        <form action=" {{ route('admin.products.destroy', $product) }} " method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <p>No Product Found</p>
            @endforelse
        </tbody>
    </table>
    {{ $products->links() }}
@endsection
