<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">All Matches</h3>

                @if(auth()->user()->role === 'admin')
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded mb-4">
                        <form action="{{ route('matches.generateMatches') }}" method="POST" class="space-y-3">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                <div class="flex flex-col">
                                    <label for="date" class="block text-sm font-medium">Start Date (optional)</label>
                                    <input type="date" name="date" id="date" placeholder="dd-mm-jjjj" class="text-gray-900 dark:text-gray-900 mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-12 px-3" />
                                    <p class="text-xs text-gray-500 mt-1">Format: dd-mm-yyyy (optional)</p>
                                </div>

                                <div class="flex flex-col">
                                    <label class="block text-sm font-medium">Teams (optional)</label>
                                    <select name="teams[]" id="teams" multiple class="text-gray-900 dark:text-gray-900 mt-1 block w-full rounded border-gray-300 h-12 overflow-y-auto shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-2">
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple teams. Leave empty to include all teams.</p>
                                </div>

                                <div class="flex flex-col">
                                    <label for="fields_count" class="block text-sm font-medium">Number of fields</label>
                                    <input type="number" name="fields_count" id="fields_count" value="4" min="1" class=" text-gray-900 dark:text-gray-900 mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-12 px-3" />
                                    <p class="text-xs text-gray-500 mt-1">How many fields are available (default 4)</p>
                                </div>

                                <div class="flex items-center md:justify-start">
                                    <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-4 py-2 rounded h-12">Generate Matches</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                @php
                    $allMatches = \App\Models\MatchModel::with('team1','team2')->get();
                @endphp

                @if($allMatches->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NR.</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Team 1</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Team 2</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Field</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Scheidsrechter</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Start time</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($allMatches as $match)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $match->team1->name }}</td>
                                    <td class="px-4 py-2">{{ $match->team2->name }}</td>
                                    <td class="px-4 py-2">{{ $match->field ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $match->referee ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $match->score ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ optional($match->start_time)->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('matches.edit', $match) }}" class="px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md text-sm">Edit</a>

                                            <form action="{{ route('matches.destroy', $match) }}" method="POST" onsubmit="return confirm('Delete this match?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm">Delete</button>
                                            </form>

                                            <a href="{{ route('matches.scoreForm', $match) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">Fill in</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No matches found.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
