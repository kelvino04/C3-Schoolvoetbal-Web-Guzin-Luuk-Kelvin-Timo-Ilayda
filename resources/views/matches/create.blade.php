<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Create Match
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('matches.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="team1_id" :value="'Team 1'" />
                        <select name="team1_id" id="team1_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                                    shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="team2_id" :value="'Team 2'" />
                        <select name="team2_id" id="team2_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                                    shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="date" :value="'Date'" />
                        <x-text-input type="date" name="date" id="date" class="block mt-1 w-full" required/>
                    </div>

                    <div>
                        <x-input-label for="score" :value="'Score'" />
                        <x-text-input type="text" name="score" id="score" class="block mt-1 w-full"/>
                        <p class="text-sm text-gray-500">Optional, format: 2-1</p>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>Create Match</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
