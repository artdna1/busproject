<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trips Management') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 p-2">Bus Name</th>
                    <th class="border border-gray-300 p-2">Origin</th>
                    <th class="border border-gray-300 p-2">Destination</th>
                    <th class="border border-gray-300 p-2">Date</th>
                    <th class="border border-gray-300 p-2">Time</th>
                    <th class="border border-gray-300 p-2">Seat Capacity</th>
                    <th class="border border-gray-300 p-2">Available Seats</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trips as $trip)
                <tr>
                    <td class="border border-gray-300 p-2">{{ $trip->bus_name }}</td>
                    <td class="border border-gray-300 p-2">{{ $trip->origin }}</td>
                    <td class="border border-gray-300 p-2">{{ $trip->destination }}</td>
                    <td class="border border-gray-300 p-2">{{ \Carbon\Carbon::parse($trip->travel_date)->format('M d, Y') }}</td>
                    <td class="border border-gray-300 p-2">{{ \Carbon\Carbon::parse($trip->travel_time)->format('h:i A') }}</td>
                    <td class="border border-gray-300 p-2">{{ $trip->seat_capacity }}</td>
                    <td class="border border-gray-300 p-2 font-semibold text-green-600">{{ $trip->available_seats }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
