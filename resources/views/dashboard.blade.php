<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Welcome to Quantum Sky Bus') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Success Message --}}
            @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded font-semibold text-center">
                {{ session('success') }}
            </div>
            @endif

            {{-- Search Trips Box --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <h3 class="text-xl font-semibold mb-6">Ready to travel?</h3>
                <a href="{{ route('trips.search') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded">
                    Search Your Trips
                </a>
            </div>

            {{-- My Bookings Box --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <h3 class="text-xl font-semibold mb-6">View your bookings!</h3>
                <a href="{{ route('bookings.list') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded">
                    My Bookings
                </a>
            </div>

        </div>
    </div>
</x-app-layout>