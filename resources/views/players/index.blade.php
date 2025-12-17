<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">{{ $team->name }} - Players</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-end mb-4">
                    <a href="{{ route('players.create', $team->id) }}" class="bg-green-600 text-white px-3 py-2 rounded">Add Player</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Player list -->
                <div class="space-y-4">
                    @forelse($players as $player)
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-700 p-4 rounded shadow">
                            <div class="text-gray-900 dark:text-gray-100">{{ $player->name }}</div>
                            <div class="flex gap-2">
                                <a href="{{ route('players.edit', [$team->id, $player->id]) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                                <form method="POST" action="{{ route('players.destroy', [$team->id, $player->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded" onclick="return confirm('Delete this player?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500 dark:text-gray-400">No players yet.</div>
                    @endforelse
                </div>

                <a href="{{ route('teams.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-300 rounded">Back to Teams</a>
            </div>
        </div>
    </div>
</x-app-layout>
