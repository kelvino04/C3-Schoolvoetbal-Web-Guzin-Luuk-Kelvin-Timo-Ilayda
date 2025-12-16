<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
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

            @if(auth()->user()->role === 'admin')
                <div class="flex justify-end space-x-2 mb-4">
                    <a href="{{ url('matches/generate') }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md
                       text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        Generate Match Schedule
                    </a>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NR.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Team 1</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Team 2</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Field</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Scheidsrechter</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Start time</th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                @endif
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($matches as $match)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-900">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $match->team1->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $match->team2->name ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $match->field ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $match->referee ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $match->score ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($match->start_time)->format('d-m-Y H:i') }}
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

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('matches.scoreForm', $match) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">Fill in</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'admin' ? 9 : 8 }}"
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
        document.querySelectorAll("[data-sort]").forEach(header => {
            header.dataset.sortAsc = "";
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

                table.querySelectorAll(".sort-arrow").forEach(span => span.innerText = "⇅");

                header.dataset.sortAsc = (!currentAsc).toString();
                header.querySelector(".sort-arrow").innerText = currentAsc ? "↓" : "↑";
            });
        });
    </script>
</x-app-layout>
