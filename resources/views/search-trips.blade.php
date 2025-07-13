<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Search Trips') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 text-center">
            {{-- Search Form --}}
            <form method="GET" action="{{ route('trips.search.results') }}" class="bg-white p-6 rounded shadow mb-10">
                @csrf

                <div class="mb-4 text-left">
                    <label class="block font-medium">Origin</label>
                    <input type="text" name="origin" required class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4 text-left">
                    <label class="block font-medium">Destination</label>
                    <input type="text" name="destination" required class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4 text-left">
                    <label class="block font-medium">Travel Date</label>
                    <input type="date" name="travel_date" required class="w-full border rounded px-3 py-2" min="{{ now()->toDateString() }}">
                </div>

                <div class="mb-4 text-left">
                    <label class="block font-medium">Travel Time</label>
                    <input type="time" name="travel_time" required class="w-full border rounded px-3 py-2">
                </div>

                <button class="bg-indigo-600 text-white px-4 py-2 rounded font-bold">
                    Search Trips
                </button>
            </form>

            {{-- My Bookings --}}
            <div>
                <h2 class="text-2xl font-semibold mb-4">My Bookings</h2>

                @forelse ($bookings as $booking)
                <div class="p-4 bg-white rounded shadow mb-4 text-left">
                    <p><strong>From:</strong> {{ $booking->origin }}</p>
                    <p><strong>To:</strong> {{ $booking->destination }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->travel_date)->format('M d, Y') }}</p>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->travel_time)->format('h:i A') }}</p>

                    <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-3 py-1 rounded">
                            Cancel
                        </button>
                    </form>
                </div>
                @empty
                <p class="text-gray-600">No bookings found.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>