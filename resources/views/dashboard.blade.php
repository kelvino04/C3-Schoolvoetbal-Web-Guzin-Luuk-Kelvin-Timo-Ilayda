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

            x   

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
