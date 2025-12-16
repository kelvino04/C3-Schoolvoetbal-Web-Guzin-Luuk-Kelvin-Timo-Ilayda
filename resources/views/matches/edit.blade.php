<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Edit Match
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('matches.update', $match) }}">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="team1_id" :value="'Team 1'" />
                        <select name="team1_id" id="team1_id" class="block mt-1 w-full">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ $match->team1_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="team2_id" :value="'Team 2'" />
                        <select name="team2_id" id="team2_id" class="block mt-1 w-full">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ $match->team2_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="date" :value="'Date'" />
                        <x-text-input type="date" name="date" id="date" class="block mt-1 w-full" value="{{ optional($match->start_time)->format('Y-m-d') }}" required/>

                    </div>

                    <div>
                        <x-input-label for="field" :value="'Field'" />
                        <select name="field" id="field" class="block mt-1 w-full">
                            @for($f = 1; $f <= 4; $f++)
                                <option value="{{ $f }}" {{ $match->field == $f ? 'selected' : '' }}>Field {{ $f }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <x-input-label for="score" :value="'Score'" />
                        <x-text-input type="text" name="score" id="score" class="block mt-1 w-full" value="{{ $match->score }}"/>
                        <p class="text-sm text-gray-500">Optional, format: 2-1</p>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>Update Match</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
