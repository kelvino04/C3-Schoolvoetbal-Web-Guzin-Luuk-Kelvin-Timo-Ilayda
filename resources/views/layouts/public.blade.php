<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'School Football' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased flex flex-col min-h-screen">

    <!-- Header -->
    <header class="w-full bg-blue-600 dark:bg-blue-800 text-white py-4 shadow">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">School Football</h1>
            <nav class="space-x-4">
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
                <a href="{{ route('register') }}" class="hover:underline">Register</a>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 py-4 mt-auto shadow-inner">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            © 2025 Team:<br>
            Güzin K. | Ilayda Ç. | Kelvin S. | Luuk D. | Timo V.
        </div>
    </footer>

</body>
</html>
