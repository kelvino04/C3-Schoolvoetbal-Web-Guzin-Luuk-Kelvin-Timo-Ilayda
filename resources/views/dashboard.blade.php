<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Create Team Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Create New Team</h3>
                    <form method="POST" action="{{ route('teams.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="name" :value="__('Team Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="points" :value="__('Points')" />
                                <x-text-input id="points" class="block mt-1 w-full" type="number" name="points" :value="old('points', 0)" min="0" autocomplete="points" />
                                <x-input-error :messages="$errors->get('points')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Create Team') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            @php
                $allTeams = \App\Models\Team::with('creator')->get();
            @endphp

            @if(auth()->user()->role === 'admin')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Admin: Manage All Teams
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name<span class="sort-arrow">⇅</span></th>
                                    <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Points<span class="sort-arrow">⇅</span></th>
                                    <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Creator<span class="sort-arrow">⇅</span></th>
                                    <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At<span class="sort-arrow">⇅</span></th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($allTeams as $team)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-100">{{ $team->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-300">{{ $team->points }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-300">{{ $team->creator->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-300">{{ $team->created_at->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4 text-right">

                                            <a href="{{ route('teams.edit', $team) }}"
                                            class="text-indigo-600 hover:text-indigo-900 mr-4">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('teams.destroy', $team) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Delete this team?')">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Teams List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Your Teams</h3>
                    @php
                        $teams = \App\Models\Team::where('creator_id', auth()->id())->get();
                    @endphp
                    @if($teams->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th data-sort scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name<span class="sort-arrow">⇅</span></th>
                                        <th data-sort scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Points<span class="sort-arrow">⇅</span></th>
                                        <th data-sort scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At<span class="sort-arrow">⇅</span></th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($teams as $team)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $team->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $team->points }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $team->created_at->format('d-m-Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('teams.edit', $team) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4">Edit</a>
                                                <form method="POST" action="{{ route('teams.destroy', $team) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this team?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No teams found. Create your first team above!</p>
                    @endif
                </div>

                <!-- All Teams List -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">All Teams</h3>

                        @php
                            $allTeams = \App\Models\Team::all();
                        @endphp

                        @if($allTeams->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name<span class="sort-arrow">⇅</span></th>
                                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Points<span class="sort-arrow">⇅</span></th>
                                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Creator<span class="sort-arrow">⇅</span></th>
                                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At<span class="sort-arrow">⇅</span></th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($allTeams as $team)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $team->name }}
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $team->points }}
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $team->creator->name ?? 'Unknown' }}
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $team->created_at->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No teams found.</p>
                        @endif
                    </div>
                </div>

            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="..\">Ga terug</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll("[data-sort]").forEach(header => {
        header.dataset.sortAsc = ""; // no sort initially
        header.addEventListener("click", () => {
            const table = header.closest("table");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));
            const index = Array.from(header.parentNode.children).indexOf(header);
            const currentAsc = header.dataset.sortAsc === "true";

            // Sort rows
            rows.sort((a, b) => {
                const A = a.children[index].innerText.trim().toLowerCase();
                const B = b.children[index].innerText.trim().toLowerCase();
                return currentAsc ? B.localeCompare(A, undefined, {numeric: true}) :
                                    A.localeCompare(B, undefined, {numeric: true});
            });

            tbody.innerHTML = "";
            rows.forEach(r => tbody.appendChild(r));

            // Reset all arrows
            table.querySelectorAll(".sort-arrow").forEach(span => span.innerText = "⇅");

            // Update arrow for current column
            header.dataset.sortAsc = (!currentAsc).toString();
            header.querySelector(".sort-arrow").innerText = currentAsc ? "↓" : "↑";
        });
    });
    </script>
</x-app-layout>
