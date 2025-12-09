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
                    <A href="{{ route('teams.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4">All Teams</A>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Create new Match</h3>
                    <A href="{{ route('matches.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4">All Teams</A>
                </div>
            </div>

            @php
                $allTeams = \App\Models\Team::with('creator')->get();
            @endphp
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">All Matches</h3>

                        @php
                            $allmatches = \App\Models\Team::all();
                        @endphp

                        @if($allmatches->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Creator<span class="sort-arrow">⇅</span></th>
                                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At<span class="sort-arrow">⇅</span></th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($allmatches as $match)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $match->team1 }} vs {{ $match->team2 }}
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ optional($match->match_date)->format('d-m-Y') ?? 'Unknown' }}

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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="..\">Go Back</a>
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
