<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshSoy - Sign In</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen flex">

    {{-- Kiri: Branding --}}
    <div
        class="hidden lg:flex w-1/2 bg-gradient-to-br from-red-600 to-yellow-400 flex-col items-center justify-center p-12">
        <img src="{{ asset('storage/products/logo_freshsoy.jpg') }}" alt="FreshSoy"
            class="w-40 h-40 object-cover rounded-full shadow-2xl mb-8 border-4 border-white">
        <h1 class="text-white text-4xl font-bold mb-4 text-center">FreshSoy POS</h1>
        <p class="text-white/80 text-center text-lg">
            Sistem Point of Sale untuk mengelola penjualan dengan mudah dan efisien.
        </p>
    </div>

    {{-- Kanan: Form Login --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-white p-8">
        <div class="w-full max-w-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome back</h2>
            <p class="text-gray-500 mb-8">Sign in to your FreshSoy account</p>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="admin@freshsoy.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="••••••••">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300">
                    <label for="remember" class="text-sm text-gray-600">Remember me</label>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium text-lg">
                    Sign In
                </button>
            </form>
        </div>
    </div>

</body>

</html>
