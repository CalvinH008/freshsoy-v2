@extends('layouts.app')
@section('content')
    <h2>Category Management</h2>
    <form action=" {{ route('admin.categories.index') }} " method="GET">
        <input type="search" name="search" value=" {{ request('search') }} " placeholder="Find Category">
        <select name="is_active">
            <option value="" disabled selected>Status</option>
            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" name="sort">Sort</button>
        <a href="{{ route('admin.categories.index') }}">Reset</a>
    </form>

    <a href=" {{ route('admin.categories.create') }} ">Add Categories</a>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $category->name }} </td>
                    <td> {{ $category->slug }} </td>
                    <td> {{ $category->description }} </td>
                    <td>
                        <a href=" {{ route('admin.categories.edit', $category) }} ">edit</a>
                        <form action=" {{ route('admin.categories.destroy', $category) }} " method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">hapus</button>
                        </form>
                        <input type="checkbox">
                        <label for="is_active">Active</label>
                    </td>
                </tr>
            @empty
                <p>No Category Found</p>
            @endforelse
        </tbody>
    </table>
    {{ $categories->links() }}
@endsection
