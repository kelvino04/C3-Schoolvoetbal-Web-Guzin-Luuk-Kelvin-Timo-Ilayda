<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Teams
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

            @if(auth()->user()->role === 'admin')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('teams.create') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm
                        text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Create Team</a>
                </div>
            @endif

            <h3 class="text-lg font-medium mb-4">All Teams</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            @if(auth()->user()->role === 'admin')
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($teams as $team)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $team->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $team->points }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $team->created_at ? $team->created_at->format('d-m-Y') : '-' }}
                                </td>

                                @if(auth()->user()->role === 'admin')
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">

                                            <a href="{{ route('teams.edit', $team) }}"
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md
                                               bg-yellow-400 hover:bg-yellow-500 text-white focus:outline-none">Edit</a>

                                            <form action="{{ route('teams.destroy', $team) }}" method="POST" onsubmit="return confirm('Delete this team?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md
                                                    bg-red-600 hover:bg-red-700 text-white focus:outline-none">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}" class="px-4 py-6 text-center text-sm text-gray-500">
                                    No teams yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
