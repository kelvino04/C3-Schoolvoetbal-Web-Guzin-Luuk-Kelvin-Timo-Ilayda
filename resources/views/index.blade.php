@extends('layouts.public')

@section('content')
<div class="text-center py-12 max-w-3xl mx-auto space-y-6">
    <h1 class="text-4xl font-bold">School Football Tournament</h1>
    <p class="text-gray-600 dark:text-gray-300">
        Welcome! Register, create teams, and join the tournament to compete in a fun and safe environment.
    </p>

    <div class="flex justify-center gap-4 mt-6">
        <a href="{{ route('login') }}"
           class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Login
        </a>

        <a href="{{ route('register') }}"
           class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Register
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 py-12">

    <!-- Accounts Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex items-start gap-4">
        <div class="text-blue-600 dark:text-blue-400 text-3xl mt-1">
            👤
        </div>
        <div>
            <h2 class="text-2xl font-semibold mb-2">User Accounts</h2>
            <p class="text-gray-600 dark:text-gray-300">
                Players register themselves using the players table. New users are never admins by default and can join a team later.
            </p>
        </div>
    </div>

    <!-- Teams Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex items-start gap-4">
        <div class="text-green-600 dark:text-green-400 text-3xl mt-1">
            ⚽
        </div>
        <div>
            <h2 class="text-2xl font-semibold mb-2">Teams</h2>
            <p class="text-gray-600 dark:text-gray-300">
                Users can create, edit, and manage their own teams. Admins can delete any team. Players can be added to teams by the creator or admin.
            </p>
        </div>
    </div>

    <!-- Tournament & Matches Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex items-start gap-4">
        <div class="text-red-600 dark:text-red-400 text-3xl mt-1">
            🏟️
        </div>
        <div>
            <h2 class="text-2xl font-semibold mb-2">Tournament & Matches</h2>
            <p class="text-gray-600 dark:text-gray-300">
                Admins generate the match schedule. Matches are assigned to fields with start times calculated from match duration, breaks, and start time. Scores are entered after matches, awarding points (win = 3, draw = 1, loss = 0). Top 5 teams appear on the dashboard.
            </p>
        </div>
    </div>

    <!-- Contact Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex items-start gap-4">
        <div class="text-yellow-600 dark:text-yellow-400 text-3xl mt-1">
            📞
        </div>
        <div>
            <h2 class="text-2xl font-semibold mb-2">Contact</h2>
            <p class="text-gray-600 dark:text-gray-300">
                For questions about registration, teams, or the tournament, contact us at
                <a href="mailto:tournament@example.com" class="text-blue-600 dark:text-blue-400 hover:underline">tournament@example.com</a>
                or call +31 6 12345678.
            </p>
        </div>
    </div>

</div>
@endsection
