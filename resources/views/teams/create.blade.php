<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Create Team
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('teams.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Team Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <p id="nameError" class="text-sm text-red-600 mt-1 hidden"></p>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>{{ __('Create Team') }}</x-primary-button>
                    </div>

                    <script>
                        document.querySelector('form').addEventListener('submit', function(e){
                            const name = document.getElementById('name').value.trim();
                            const error = document.getElementById('nameError');
                            error.classList.add('hidden'); error.innerText = '';
                            if(name === '') { e.preventDefault(); error.innerText='Team name mag niet leeg zijn'; error.classList.remove('hidden'); return; }
                            if(name.length < 2) { e.preventDefault(); error.innerText='Team name moet minimaal 2 karakters zijn'; error.classList.remove('hidden'); }
                        });
                    </script>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
