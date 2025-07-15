{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app') {{-- or your layout --}}

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Pending Admin Approvals</h1>

        @if (session('status'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('status') }}
            </div>
        @endif

        @if ($pendingAdmins->isEmpty())
            <p>No pending admin registrations.</p>
        @else
            <table class="table-auto w-full border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingAdmins as $admin)
                        <tr>
                            <td class="border px-4 py-2">{{ $admin->name }}</td>
                            <td class="border px-4 py-2">{{ $admin->email }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('super-admin.approve', $admin->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                            Approve
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('super-admin.decline', $admin->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
