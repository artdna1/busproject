<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;

class AdminTripController extends Controller
{
    public function index()
    {
        $trips = Trip::latest()->get();
        return view('admin.dashboard', compact('trips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'travel_date' => 'required|date',
            'travel_time' => 'required|date_format:H:i',
        ]);

        Trip::create($validated);

        return redirect()->back()->with('success', 'Trip added successfully.');
    }

    public function destroy($id)
    {
        Trip::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Trip removed successfully.');
    }
}

