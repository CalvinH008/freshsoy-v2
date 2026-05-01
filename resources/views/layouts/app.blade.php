<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshSoy - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex h-screen bg-gray-100">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-4 text-xl font-bold border-b border-gray-700">FreshSoy</div>
        @include('partials.sidebar')
    </aside>

    {{-- Main Area --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Navbar --}}
        <header class="bg-white shadow px-6 py-4">
            @include('partials.navbar')
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif
            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif
            @yield('content')
        </main>

    </div>

</body>

</html>
