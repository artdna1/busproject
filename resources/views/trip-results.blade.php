<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Available Trips') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto text-center">
        {{-- Flash Success Message --}}
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 font-semibold">
            {{ session('success') }}
        </div>
        @endif

        {{-- Search Message --}}
        <div class="mb-6 text-gray-700 font-medium">
            {{ $message }}
        </div>

        {{-- Trip Results --}}
        @forelse ($trips as $trip)
        <div class="bg-white p-6 rounded shadow mb-8 text-left max-w-2xl mx-auto">
            <p><strong>From:</strong> {{ $trip->origin }}</p>
            <p><strong>To:</strong> {{ $trip->destination }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($trip->travel_date)->format('M d, Y') }}</p>
            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($trip->travel_time)->format('h:i A') }}</p>
            <p><strong>Price:</strong> ₱{{ number_format($trip->price, 2) }}</p>
            <p><strong>Seats Available:</strong> {{ $trip->seatsAvailable() }}</p>

            @if($trip->seatsAvailable() > 0)
            <form method="POST" action="{{ route('bookings.store') }}" class="mt-4">
                @csrf
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                {{-- Seat Number --}}
                <div class="mb-4">
                    <label for="seat_number" class="block font-semibold mb-1">Seat Number</label>
                    <input type="text" name="seat_number" id="seat_number" required class="w-full border rounded px-3 py-2">
                </div>

                {{-- Payment Method --}}
                <div class="mb-4">
                    <label for="payment_method" class="block font-semibold mb-1">Payment Method</label>
                    <select name="payment_method" id="payment_method" required class="w-full border rounded px-3 py-2">
                        <option value="">-- Select --</option>
                        <option value="GCash">GCash</option>
                        <option value="BankTransfer">Bank Transfer</option>
                        <option value="PayMaya">PayMaya</option>
                        <option value="ShopeePay">ShopeePay</option>
                        <option value="GrabPay">GrabPay</option>
                        <option value="Coins.ph">Coins.ph</option>
                    </select>
                </div>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded">
                    Book This Trip
                </button>
            </form>
            @else
            <p class="text-red-600 font-semibold mt-2">No seats available</p>
            @endif
        </div>
        @empty
        <p class="text-gray-600">No trips found.</p>
        @endforelse
    </div>
</x-app-layout>