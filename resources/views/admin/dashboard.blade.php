@extends('layouts.app')
@section('title', 'Admin Panel')
@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Card -->
        <x-card>
            <p class="text-sm text-gray-500">Total Users</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalUsers }}</h2>
        </x-card>

        <x-card>
            <p class="text-sm text-gray-500">Total Outlets</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalOutlets }}</h2>
        </x-card>

        <x-card>
            <p class="text-sm text-gray-500">Total Products</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalProducts }}</h2>
        </x-card>

        <x-card>
            <p class="text-sm text-gray-500">Total Categories</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalCategories }}</h2>
        </x-card>

    </div>

@endsection
