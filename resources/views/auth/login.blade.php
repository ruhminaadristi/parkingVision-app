@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 ">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700  text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="email" type="email" name="email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-gray-700  text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                       id="password" type="password" name="password" required />
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                    Sign In
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                   href="{{ route('admin.register') }}">
                    Register Admin
                </a>
            </div>

            @if ($errors->any())
                <div class="mt-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-500 text-xs italic">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
