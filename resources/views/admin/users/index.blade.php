@extends('layouts.app')
@section('title', 'User Management')
@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add User
        </a>
    </div>

    {{-- Search & Filter --}}
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-3 mb-6 bg-white p-4 rounded-lg shadow">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Find User"
            class="border border-gray-300 rounded-lg px-3 py-2 flex-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select name="role" class="border rounded px-3 py-2">
            <option value="" disabled selected>Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
            <option value="cashier" {{ request('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
        </select>
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
            Filter
        </button>
        <a href="{{ route('admin.users.index') }}" class="border px-4 py-2 rounded hover:bg-gray-100">
            Reset
        </a>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Outlet</th>
                    <th class="px-4 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td class="px-4 py-3">{{ $user->outlet->name ?? '-' }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                                Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No User Found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>

@endsection
