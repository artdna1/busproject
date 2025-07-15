<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Get only admins with status pending
        $pendingAdmins = User::where('role', 'admin')
            ->where('status', 'pending')
            ->get();

        return view('superadmin.dashboard', compact('pendingAdmins'));
    }

    public function approve($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->role === 'admin' && $admin->status === 'pending') {
            $admin->status = 'approved';
            $admin->save();
            return back()->with('success', 'Admin approved successfully.');
        }

        return back()->with('error', 'Invalid admin or already approved.');
    }

    public function decline($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->role === 'admin' && $admin->status === 'pending') {
            $admin->status = 'declined';
            $admin->save();
            return back()->with('success', 'Admin declined.');
        }

        return back()->with('error', 'Invalid admin or already declined.');
    }
    public function showTrips()
{
    $trips = \App\Models\Trip::orderBy('travel_date')->get();
    return view('admin.trips', compact('trips'));
}

}
