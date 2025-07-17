<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Trip
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('trips.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium">Bus Name</label>
                    <input type="text" name="bus_name" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Origin</label>
                    <input type="text" name="origin" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Destination</label>
                    <input type="text" name="destination" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Departure Time</label>
                    <input type="datetime-local" name="departure_time" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Arrival Time</label>
                    <input type="datetime-local" name="arrival_time" class="w-full border px-3 py-2 rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Price</label>
                    <input type="number" step="0.01" name="price" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Seats Available</label>
                    <input type="number" name="seats_available" class="w-full border px-3 py-2 rounded" required>
                </div>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Add Trip
                </button>
            </form>
        </div>
    </div>
</x-app-layout>