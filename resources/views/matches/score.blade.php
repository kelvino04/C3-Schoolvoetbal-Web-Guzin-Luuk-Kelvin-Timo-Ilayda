<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Match Score</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">{{ $match->team1->name ?? 'N/A' }} vs {{ $match->team2->name ?? 'N/A' }}</h3>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Field</p>
                        <p class="text-gray-900">{{ $match->field ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Start</p>
                        <p class="text-gray-900">{{ optional($match->start_time)->format('d-m-Y H:i') ?? '-' }}</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(auth()->user() && auth()->user()->isAdmin())
                    <form action="{{ route('matches.updateScore', $match) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-2 gap-4 items-end">
                            <div>
                                <label for="score_team1" class="block text-sm font-medium text-gray-700">{{ $match->team1->name ?? 'Team 1' }}</label>
                                <input type="number" name="score_team1" id="score_team1" value="{{ old('score_team1', $homeScore) }}" min="0" class="text-gray-900 dark:text-gray-900 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                @error('score_team1') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="score_team2" class="block text-sm font-medium text-gray-700">{{ $match->team2->name ?? 'Team 2' }}</label>
                                <input type="number" name="score_team2" id="score_team2" value="{{ old('score_team2', $awayScore) }}" min="0" class="text-gray-900 dark:text-gray-900 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                @error('score_team2') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('matches.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save Score</button>
                        </div>
                    </form>
                @else
                    <div class="p-4 bg-gray-50 rounded">
                        <p class="text-sm text-gray-500">Score</p>
                        <p class="text-lg font-medium">{{ $match->score ?? '-' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
