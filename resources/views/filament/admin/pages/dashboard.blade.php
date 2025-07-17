{{-- resources/views/filament/admin/pages/dashboard.blade.php --}}
<x-filament::page>
    <h1 class="text-xl font-bold mb-6">Admin Dashboard - Manage Trips</h1>

    {{-- Flash Success --}}
    @if(session('success'))
        <div class="p-4 bg-green-100 text-green-800 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add Trip Form --}}
    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="text-xl font-semibold mb-4">Add New Trip</h3>
        <form method="POST" action="{{ route('admin.trips.store') }}">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="origin">Origin</label>
                    <input type="text" name="origin" id="origin" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label for="destination">Destination</label>
                    <input type="text" name="destination" id="destination" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label for="travel_date">Travel Date</label>
                    <input type="date" name="travel_date" id="travel_date" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div>
                    <label for="travel_time">Travel Time</label>
                    <input type="time" name="travel_time" id="travel_time" class="w-full border px-3 py-2 rounded" required>
                </div>
            </div>

            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Add Trip</button>
        </form>
    </div>

    {{-- List of Trips --}}
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-xl font-semibold mb-4">All Trips</h3>

        @forelse($trips as $trip)
            <div class="border p-4 rounded mb-3 bg-gray-50">
                <p><strong>From:</strong> {{ $trip->origin }}</p>
                <p><strong>To:</strong> {{ $trip->destination }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($trip->travel_date)->format('M d, Y') }}</p>
                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($trip->travel_time)->format('h:i A') }}</p>

                <form action="{{ route('admin.trips.destroy', $trip->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700" type="submit">Remove</button>
                </form>
            </div>
        @empty
            <p>No trips available.</p>
        @endforelse
    </div>
</x-filament::page>
