<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Quantum Sky Bus') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Booking Form --}}
            <div class="bg-white p-6 rounded shadow mb-10">
                <h2 class="text-2xl font-semibold mb-6">Book a Bus</h2>

                <form method="POST" action="{{ route('bookings.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="origin" class="block font-medium">Origin (City, Province)</label>
                            <input type="text" name="origin" id="origin" placeholder="e.g. San Fernando, Pampanga" class="w-full border rounded px-3 py-2 mt-1" required>
                        </div>

                        <div>
                            <label for="destination" class="block font-medium">Destination (City, Province)</label>
                            <input type="text" name="destination" id="destination" placeholder="e.g. Angeles City, Pampanga" class="w-full border rounded px-3 py-2 mt-1" required>

                            @error('destination')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="travel_date" class="block font-medium">Travel Date</label>
                            <input type="date" name="travel_date" id="travel_date" class="w-full border rounded px-3 py-2 mt-1" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div>
                            <label for="travel_time" class="block font-medium">Travel Time</label>
                            <input type="time" name="travel_time" id="travel_time" class="w-full border rounded px-3 py-2 mt-1" required>
                        </div>
                    </div>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-bold">
                        Book Now
                    </button>
                </form>
            </div>

            {{-- Flash Message --}}
            @if(session('success'))
            <div class="text-green-600 mb-6 font-semibold">
                {{ session('success') }}
            </div>
            @endif

            {{-- Bookings List --}}
            <div>
                <h2 class="text-2xl font-semibold mb-4">My Bookings</h2>

                @forelse ($bookings as $booking)
                <div class="p-4 bg-white rounded shadow mb-4">
                    <p><strong>From:</strong> {{ $booking->origin }}</p>
                    <p><strong>To:</strong> {{ $booking->destination }}</p>
                    <p><strong>Date:</strong> {{ $booking->travel_date }}</p>
                    <p><strong>Time:</strong> {{ $booking->travel_time }}</p>

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

        <script>
            const form = document.querySelector('form');
            const originInput = document.getElementById('origin');
            const destinationInput = document.getElementById('destination');

            form.addEventListener('submit', function(e) {
                const origin = originInput.value.trim().toLowerCase();
                const destination = destinationInput.value.trim().toLowerCase();

                if (origin === destination) {
                    e.preventDefault();
                    alert('Origin and Destination cannot be the same.');
                }
            });
        </script>

    </div>

</x-app-layout>