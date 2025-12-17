<x-app-layout>
    <x-slot name="header">
        <h2>Add Player - {{ $team->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('players.store', $team->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Player Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('name') <p class="text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('players.index', $team->id) }}" class="px-4 py-2 bg-gray-300 rounded">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Add Player</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

