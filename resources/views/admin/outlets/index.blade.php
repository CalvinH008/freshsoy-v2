@extends('layouts.app')
@section('content')
    <h2>Outlet Management</h2>
    <a href=" {{ route('admin.outlets.create') }} ">Add Outlet</a>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($outlets as $outlet)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $outlet->name }} </td>
                    <td> {{ $outlet->code }} </td>
                    <td> {{ $outlet->address }} </td>
                    <td> {{ $outlet->phone }} </td>
                    <td>
                        <a href=" {{ route('admin.outlets.edit', $outlet) }} ">edit</a>
                        <form action=" {{ route('admin.outlets.destroy', $outlet) }} " method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <p>tidak ada outlet</p>
            @endforelse
        </tbody>
    </table>
    {{ $outlets->links() }}
@endsection
