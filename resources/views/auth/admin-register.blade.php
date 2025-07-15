<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Admin Registration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.register.submit') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700">Password</label>
                        <input type="password" name="password" required
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-6">
                        <label class="block font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded w-full">
                        Register
                    </button>

                    <div class="mt-4 text-center text-sm">
                        Already have an account?
                        <a href="{{ route('admin.login') }}" class="text-indigo-600 hover:underline">
                            Log in here
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>