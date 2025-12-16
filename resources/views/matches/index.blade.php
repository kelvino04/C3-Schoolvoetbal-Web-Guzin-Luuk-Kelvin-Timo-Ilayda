<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Matches
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

            @if(auth()->user()->role === 'admin')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('matches.create') }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md
                       text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                        Create Match
                    </a>
                </div>
            @endif

            <div class="overflow-x-auto">
                <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">All Matches</h3>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Home Team <span class="sort-arrow">⇅</span>
                            </th>
                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Away Team <span class="sort-arrow">⇅</span>
                            </th>
                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date <span class="sort-arrow">⇅</span>
                            </th>
                            <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Score <span class="sort-arrow">⇅</span>
                            </th>
                            @if(auth()->user()->role === 'admin')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($matches as $match)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $match->team1->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $match->team2->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($match->date)->format('d-m-Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $match->score ?? '-' }}
                                </td>
                                @if(auth()->user()->role === 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('matches.edit', $match) }}"
                                               class="px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('matches.destroy', $match) }}" method="POST" onsubmit="return confirm('Delete this match?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}"
                                    class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No matches found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Sorting functionality for table headers
        document.querySelectorAll("[data-sort]").forEach(header => {
            header.dataset.sortAsc = ""; // no sort initially
            header.addEventListener("click", () => {
                const table = header.closest("table");
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.querySelectorAll("tr"));
                const index = Array.from(header.parentNode.children).indexOf(header);
                const currentAsc = header.dataset.sortAsc === "true";

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
