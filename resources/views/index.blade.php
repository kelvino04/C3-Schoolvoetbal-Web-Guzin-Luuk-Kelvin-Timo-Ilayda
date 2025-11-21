@extends('layouts.public')

@section('content')
<div class="text-center space-y-6">
    <h1 class="text-3xl font-bold">Welcome to School Football</h1>

    <p class="text-gray-600 dark:text-gray-300">
        Choose an option to continue:
    </p>

    <div class="flex justify-center gap-4 mt-6">
        <a href="{{ route('login') }}"
           class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Login
        </a>

        <a href="{{ route('register') }}"
           class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Register
        </a>
    </div>
</div>
@endsection
