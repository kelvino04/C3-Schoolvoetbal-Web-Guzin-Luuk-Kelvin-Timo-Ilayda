<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    @if(auth()->user()?->role === 'admin')
        @foreach ($users as $user)
            <div class="mb-4 p-4 bg-white dark:bg-gray-800 shadow rounded-lg">
                <form method="POST" action="{{ route('admin.updateRole', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $user->name }} ({{ $user->email }})
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div>
                                <x-input-label for="role-{{ $user->id }}" :value="__('Role')" />
                                <select id="role-{{ $user->id }}" name="role"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                                    shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                            <div>
                                <x-primary-button>{{ __('Update Role') }}</x-primary-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    @else
        <p class="text-red-600 font-semibold">You do not have permission to view this page.</p>
    @endif
</x-app-layout>

