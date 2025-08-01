<x-app-layout>
    <x-slot name="header">
        <div class="text-center mb-4">
            <h2 class="text-3xl font-extrabold text-indigo-800">
                Welcome to <span class="text-blue-600">Quantum Sky Bus</span>
            </h2>
            <p class="text-gray-500 mt-1">Book your trips with ease</p>
        </div>
    </x-slot>

    <div class="py-8 bg-blue-50 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-8 px-4">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-lg shadow text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md text-center hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Search for Trips</h3>
                    <a href="{{ route('trips.search') }}"
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded shadow">
                        Search Trips
                    </a>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md text-center hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">View Your Bookings</h3>
                    <a href="{{ route('bookings.list') }}"
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded shadow">
                        My Bookings
                    </a>
                </div>
            </div>

            {{-- Available Trips --}}
            @if($trips->count())
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-2xl font-bold text-center text-gray-700 mb-6">Available Trips</h3>

                    <div class="space-y-8">
                        @foreach($trips as $trip)
                            @php
                                $availableSeats = $trip->seat_capacity - $trip->approved_bookings_count;
                                $bookedSeats = $trip->bookedSeatNumbers();
                            @endphp

                            <div class="border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-lg transition bg-gradient-to-r from-white via-blue-50 to-white">
                                <div class="grid md:grid-cols-2 gap-6 text-gray-800">
                                    <div>
                                        <p><strong>From:</strong> {{ $trip->origin }}</p>
                                        <p><strong>To:</strong> {{ $trip->destination }}</p>
                                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($trip->travel_date)->format('M d, Y') }}</p>
                                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($trip->travel_time)->format('h:i A') }}</p>
                                    </div>
                                    <div>
                                        <p><strong>Bus Name:</strong> {{ $trip->bus_name }}</p>
                                        <p><strong>Price:</strong> ₱{{ number_format($trip->price, 2) }}</p>
                                        <p><strong>Seat Capacity:</strong> {{ $trip->seat_capacity }}</p>
                                        <p><strong>Available Seats:</strong>
                                            <span class="{{ $availableSeats > 0 ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                                {{ $availableSeats }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                {{-- Booking Form --}}
                                @if($availableSeats > 0)
                                    <form method="POST" action="{{ route('bookings.store') }}" class="mt-6 space-y-4">
                                        @csrf
                                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                                        {{-- Seat Number Dropdown --}}
                                        <div class="text-center">
                                            <label class="block font-semibold mb-1">Seat Number</label>
                                            <select name="seat_number" required class="w-full md:w-1/3 mx-auto px-3 py-2 border border-gray-300 rounded">
                                                <option value="" disabled selected>-- Select Seat --</option>
                                                @foreach (range(1, $trip->seat_capacity) as $i)
                                                    @php
                                                        $seat = 'S' . $i;
                                                    @endphp
                                                    @if (in_array($seat, $bookedSeats))
                                                        <option value="" disabled>{{ $seat }} (Taken)</option>
                                                    @else
                                                        <option value="{{ $seat }}">{{ $seat }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Payment Method Dropdown --}}
                                        <div class="text-center">
                                            <label class="block font-semibold mb-1">Payment Method</label>
                                            <select name="payment_method" required class="w-full md:w-1/3 mx-auto px-3 py-2 border border-gray-300 rounded">
                                                <option value="" disabled selected>-- Select --</option>
                                                @foreach (['GCash', 'BankTransfer', 'PayMaya', 'ShopeePay', 'GrabPay', 'Coins.ph'] as $method)
                                                    <option value="{{ $method }}">{{ $method }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Submit Button --}}
                                        <div class="text-center">
                                            <button type="submit"
                                                    class="w-full md:w-auto bg-blue-900 hover:bg-blue-950 text-white font-bold px-6 py-2 rounded-xl shadow-lg transition duration-200">
                                                🚍 Book This Trip
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <p class="text-red-500 font-semibold text-center mt-4">No seats available</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-center text-gray-600 font-medium mt-10">No trips available today.</p>
            @endif
        </div>
    </div>
</x-app-layout>
