<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Welcome to Quantum Sky Bus') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Success Message --}}
            @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-6 font-semibold">
                {{ session('success') }}
            </div>
            @endif

            {{-- Main CTA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <h3 class="text-xl font-semibold mb-6">Ready to travel?</h3>
                <a href="{{ route('trips.search') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded">
                    Search Your Trips
                </a>
            </div>

        </div>
    </div>
</x-app-layout>