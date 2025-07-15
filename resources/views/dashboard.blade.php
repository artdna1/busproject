<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Welcome to Quantum Sky Bus') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded font-semibold text-center shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search Trips --}}
            <div class="bg-white shadow-md sm:rounded-lg p-6 text-center">
                <h3 class="text-2xl font-bold mb-4 text-gray-700">Ready to travel?</h3>
                <a href="{{ route('trips.search') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded shadow">
                    Search Your Trips
                </a>
            </div>

            {{-- My Bookings --}}
            <div class="bg-white shadow-md sm:rounded-lg p-6 text-center">
                <h3 class="text-2xl font-bold mb-4 text-gray-700">View your bookings!</h3>
                <a href="{{ route('bookings.list') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded shadow">
                    My Bookings
                </a>
            </div>

            {{-- Available Trips --}}
            @if($trips->count())
                <div class="bg-white shadow-md sm:rounded-lg p-6">
                    <h3 class="text-2xl font-bold mb-6 text-center text-gray-700">Available Trips</h3>

                    @foreach($trips as $trip)
                        <div class="border border-gray-200 rounded-lg p-5 mb-6 shadow-sm hover:shadow-lg transition">
                            <div class="grid md:grid-cols-2 gap-4 text-gray-800">
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
                                    <p>
                                        <strong>Available Seats:</strong>
                                        <span class="{{ $trip->seatsAvailable() > 0 ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                            {{ $trip->seatsAvailable() }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            {{-- Book Button or No Seats --}}
                            <div class="mt-4 text-center">
                                @if($trip->seatsAvailable() > 0)
                                    <form action="{{ route('bookings.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded shadow">
                                            Book This Trip
                                        </button>
                                    </form>
                                @else
                                    <p class="text-red-500 font-semibold">No seats available</p>
                                @endif
                            </div>

                            {{-- Error Message for this trip --}}
                            @if(session('error_trip_id') == $trip->id)
                                <div class="bg-red-100 text-red-800 p-3 mt-3 rounded text-center font-semibold">
                                    {{ session('error_message') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">No trips available at the moment.</p>
            @endif

        </div>
    </div>
</x-app-layout>
