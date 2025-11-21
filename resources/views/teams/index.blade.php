<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Teams
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <p class="text-gray-500 dark:text-gray-400">Here will be the list of teams (data from C# backend)</p>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th>Name</th>
                        <th>Points</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Example Team 1</td>
                        <td>10</td>
                        <td>21-11-2025</td>
                    </tr>
                    <tr>
                        <td>Example Team 2</td>
                        <td>5</td>
                        <td>20-11-2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
