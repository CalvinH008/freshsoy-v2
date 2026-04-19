@extends('layouts.app')
@section('content')
    <h2>edit user</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </div>
    @endif
    <form action=" {{ route('admin.users.update', $user) }} " method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" placeholder="Nama" value=" {{ old('name', $user->name) }} ">
        <br>
        <input type="email" name="email" placeholder="Email" value=" {{ old('email', $user->email) }} ">
        <br>
        <input type="password" name="password" placeholder="Password">
        <br>
        <select name="role" id="">
            <option value="" disabled selected >--pilih role--</option>
            <option value="admin" {{ old('role', $user->roles->first()->name ?? '') == 'admin' ? 'selected' : '' }}>admin
            </option>
            <option value="manager" {{ old('role', $user->roles->first()->name ?? '') == 'manager' ? 'selected' : '' }}>
                manager</option>
            <option value="cashier" {{ old('role', $user->roles->first()->name ?? '') == 'cashier' ? 'selected' : '' }}>
                cashier</option>
        </select>
        <br>
        <select name="outlet_id" id="">
            @foreach ($outlets as $outlet)
                <option value="{{ $outlet->id }}"
                    {{ old('outlet_id', $user->outlet_id) == $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
            @endforeach
        </select>
        <button type="submit">add</button>
    </form>
@endsection
