<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>


    @if (auth()->user()?->role === 'admin')
        <div>
            <x-input-label for="role" :value="__('Role')" />

            <select id="role" name="role"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700
            bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
            shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                required autocomplete="role">

                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                    User
                </option>
            </select>
        </div>
    @endif


</x-app-layout>
