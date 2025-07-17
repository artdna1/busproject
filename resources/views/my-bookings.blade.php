<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Bookings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded font-semibold text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Booking Cards --}}
            @forelse ($bookings as $booking)
                <div class="bg-white p-6 rounded shadow text-gray-800">
                    <div class="space-y-1">
                        <p><strong>From:</strong> {{ $booking->origin }}</p>
                        <p><strong>To:</strong> {{ $booking->destination }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->travel_date)->format('M d, Y') }}</p>
                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->travel_time)->format('h:i A') }}</p>
                        <p><strong>Seat Number:</strong> {{ $booking->seat_number }}</p>
                        <p><strong>Status:</strong>
                            <span class="px-2 py-1 rounded-full text-sm font-semibold
                                @if($booking->status === 'approved') bg-green-100 text-green-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif
                            ">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </p>
                    </div>
<p><strong>Payment Method:</strong> {{ $booking->payment_method }}</p>
<p><strong>Seat:</strong> {{ $booking->seat_number }}</p>
<p><strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</p>
@if($booking->payment_proof)
    <p><a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank" class="text-blue-600 underline">View Payment Proof</a></p>
@endif
                    @if($booking->status !== 'cancelled')
                        <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" class="mt-4 text-center">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure you want to cancel this booking?')"
                                type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded">
                                Cancel Booking
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-600 mt-10">You have no bookings yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
