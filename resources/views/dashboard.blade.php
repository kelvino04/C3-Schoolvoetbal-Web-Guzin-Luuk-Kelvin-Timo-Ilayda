<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Top 5 Teams</h3>

                    @php
                        $topTeams = \App\Models\Team::orderByDesc('points')->take(5)->get();
                    @endphp

                    @forelse($topTeams as $index => $team)
                        <div class="flex justify-between border-b border-gray-200 dark:border-gray-700 py-2">
                            <span>
                                {{ $index + 1 }}. {{ $team->name }}
                            </span>
                            <span class="font-medium">
                                {{ $team->points }} pts
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">
                            No teams available.
                        </p>
                    @endforelse
                </div>
            </div>

            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="..\">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
