@extends('layouts.app')
@section('content')
    <h2>User Management</h2>
    <a href=" {{ route('admin.users.create') }} ">Add User</a>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Outlet</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $user->name }} </td>
                    <td> {{ $user->email }} </td>
                    <td> {{ $user->roles->pluck('name')->join(', ') }} </td>
                    <td> {{ $user->outlet_id }} </td>
                    <td>
                        <a href=" {{ route('admin.users.edit', $user) }} ">edit</a>
                        <form action=" {{ route('admin.users.destroy', $user) }} " method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <p>tidak ada user</p>
            @endforelse
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
