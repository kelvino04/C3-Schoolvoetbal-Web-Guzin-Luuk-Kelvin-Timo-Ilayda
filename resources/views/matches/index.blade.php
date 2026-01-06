<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Matches
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(auth()->user()->role === 'admin')
                <div class="flex justify-end space-x-2 mb-4">
                    <a href="{{ url('matches/generate') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Generate Match Schedule</a>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Team 1</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Team 2</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Field</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Referee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Start Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($matches as $match)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $match->team1->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $match->team2->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $match->field ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $match->referee ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $match->score ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ optional($match->start_time)->format('d-m-Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $match->duration ?? '-' }} min</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('matches.edit', $match) }}" class="px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md text-sm">Edit</a>
                                        <form action="{{ route('matches.destroy', $match) }}" method="POST" onsubmit="return confirm('Delete this match?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm">Delete</button>
                                        </form>
                                        <a href="{{ route('matches.scoreForm', $match) }}" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm">Fill in</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No matches found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
