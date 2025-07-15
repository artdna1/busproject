{{-- resources/views/admin/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <p>Welcome, {{ Auth::user()->name }} ({{ Auth::user()->role }})</p>
                <p>This is the Admin Dashboard view.</p>
            </div>
        </div>
    </div>
</x-app-layout>
