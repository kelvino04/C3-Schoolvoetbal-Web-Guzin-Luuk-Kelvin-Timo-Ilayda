<x-base-layout>
    <div class="text-center space-y-4">
        <h2 class="text-2xl font-bold">Welkom bij Schoolvoetball</h2>
        <p>Kies een optie om verder te gaan:</p>

        <div class="flex justify-center gap-4 mt-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Login</a>
            <a href="{{ route('register') }}" class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 transition">Register</a>
        </div>
    </div>
</x-base-layout>
