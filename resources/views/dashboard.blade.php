<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Dashboard kaarten -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <h1>Extra voorbeeld kaart: Laatste wedstrijden</h1>
                    <h2 class="text-gray-500 text-sm">Laatste wedstrijden</h2>
                    <ul class="mt-2 text-gray-700 list-disc list-inside">
                        <li>Team C vs Team D – 20:00 – Winst: 10 4S-dollars</li>
                        <li>Team E vs Team F – 18:30 – Verlies: 5 4S-dollars</li>
                        <li>Team G vs Team H – 16:00 – Winst: 20 4S-dollars</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
