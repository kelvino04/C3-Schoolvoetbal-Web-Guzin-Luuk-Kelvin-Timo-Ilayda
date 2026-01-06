<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'School Football' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased flex flex-col min-h-screen">

    <!-- Header / Navbar -->
    <header class="w-full bg-blue-600 dark:bg-blue-800 text-white py-4 shadow">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">School Football</h1>

            <!-- Nav Tabs -->
            <nav class="space-x-4">
                <!-- Home -->
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'underline font-semibold' : '' }} hover:underline">
                   Home
                </a>

                <!-- Teams Dropdown -->
                <div class="dropdown">
                    <button class="dropdown-btn">Teams ▼</button>
                    <div class="dropdown-content">
                        <a href="{{ route('teams.index') }}">Team Overview</a>
                        <a href="{{ route('teams.create') }}">Add Team</a>
                    </div>
                </div>

                <!-- Schedule Dropdown -->
                <div class="dropdown">
                    <button class="dropdown-btn">Schedule ▼</button>
                    <div class="dropdown-content">
                        <a href="{{ route('matches.index') }}">View All Matches</a>
                        <a href="{{ route('matches.generateMatches') }}">Generate Matches</a>
                    </div>
                </div>

                <!-- Profile / Logout -->
                <a href="{{ route('profile.edit') }}" class="hover:underline">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>

                <!-- Admin Dashboard -->
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.index') }}"
                           class="{{ request()->routeIs('admin.*') ? 'underline font-semibold' : '' }} hover:underline">
                           Admin Dashboard
                        </a>
                    @endif
                @endauth

            </nav>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 py-8">
        {{ $slot ?? '' }}
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
