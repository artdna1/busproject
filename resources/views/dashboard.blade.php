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
                <h2 class="text-2xl font-semibold mb-6">Start Booking Here</h2>

                <form method="POST" action="{{ route('bookings.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div class="mb-4">
                            <label for="trip_id" class="block font-medium">Choose a Trip</label>
                            <select name="trip_id" id="trip_id" class="w-full border rounded px-3 py-2 mt-1" required>
                                <option value="">-- Select Trip --</option>
                                {{-- Actual trips --}}
                                @foreach($trips as $trip)
                                <option value="{{ $trip->id }}">
                                    {{ $trip->origin }} to {{ $trip->destination }} on {{ \Carbon\Carbon::parse($trip->travel_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($trip->travel_time)->format('h:i A') }}
                                </option>
                                @endforeach
                            </select>

                            {{-- ✅ Show validation error if trip_id is not selected --}}
                            @error('trip_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror

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
                    <p><strong>From:</strong> {{ $booking->trip->origin }}</p>
                    <p><strong>To:</strong> {{ $booking->trip->destination }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->trip->travel_date)->format('M d, Y') }}</p>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->trip->travel_time)->format('h:i A') }}</p>


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