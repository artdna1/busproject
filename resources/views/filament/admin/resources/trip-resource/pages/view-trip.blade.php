<x-filament::page>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">Trip Details</h2>

        <div class="border p-4 rounded bg-gray-50">
            <p><strong>Origin:</strong> {{ $record->origin }}</p>
            <p><strong>Destination:</strong> {{ $record->destination }}</p>
            <p><strong>Date:</strong> {{ $record->travel_date }}</p>
            <p><strong>Time:</strong> {{ $record->travel_time }}</p>
            <p><strong>Bus Name:</strong> {{ $record->bus_name }}</p>
            <p><strong>Seat Capacity:</strong> {{ $record->seat_capacity }}</p>
        </div>

        <h3 class="text-lg font-semibold mt-6">Seat Bookings</h3>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @for ($i = 1; $i <= $record->seat_capacity; $i++)
                @php
                    $seatNumber = 'S' . $i;
                    $booking = $record->bookings->firstWhere('seat_number', $seatNumber);
                @endphp

                <div class="border rounded p-3 {{ $booking ? 'bg-red-100' : 'bg-green-100' }}">
                    <strong>{{ $seatNumber }}</strong><br>
                    @if ($booking)
                        Taken by: {{ $booking->user->name ?? 'N/A' }}
                    @else
                        Available
                    @endif
                </div>
            @endfor
        </div>
    </div>
</x-filament::page>
