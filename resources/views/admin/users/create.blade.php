@extends('layouts.app')
@section('content')
    <h2>add user</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </div>
    @endif
    <form action=" {{ route('admin.users.store') }} " method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nama">
        <br>
        <input type="email" name="email" placeholder="Email">
        <br>
        <input type="password" name="password" placeholder="Password">
        <br>
        <select name="role" id="">
            <option value="">--pilih role--</option>
            <option value="admin">admin</option>
            <option value="manager">manager</option>
            <option value="cashier">cashier</option>
        </select>
        <br>
        <select name="outlet_id" id="">
            @foreach ($outlets as $outlet)
                <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
            @endforeach
        </select>
        <button type="submit">add</button>
    </form>
@endsection
