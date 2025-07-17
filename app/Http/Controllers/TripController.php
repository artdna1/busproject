<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;

class TripController extends Controller
{
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'travel_date' => 'required|date',
            'travel_time' => 'required',
        ]);

        Trip::create($validated);

        return redirect()->back()->with('success', 'Trip added successfully.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $trip = Trip::findOrFail($id);
        $trip->delete();

        return redirect()->back()->with('success', 'Trip deleted successfully.');
    }
}
