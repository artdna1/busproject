<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Search Trips') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Search Form --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="GET" action="{{ route('trips.search.results') }}">
                    @csrf

                    {{-- Origin --}}
                    <div class="mb-4">
                        <label class="block font-medium">Origin</label>
                        <input type="text" name="origin" required class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Destination --}}
                    <div class="mb-4">
                        <label class="block font-medium">Destination</label>
                        <input type="text" name="destination" required class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Date --}}
                    <div class="mb-4">
                        <label class="block font-medium">Travel Date</label>
                        <input type="date" name="travel_date" required class="w-full border rounded px-3 py-2"
                            min="{{ now()->toDateString() }}">
                    </div>

                    {{-- Time --}}
                    <div class="mb-4">
                        <label class="block font-medium">Travel Time</label>
                        <input type="time" name="travel_time" required class="w-full border rounded px-3 py-2">
                    </div>

                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded w-full">
                        Search Trips
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>