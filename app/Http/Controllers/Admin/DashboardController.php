<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // USER → show only his bookings
        // ADMIN / SUPER ADMIN → show all bookings
        $filter = $user->role === 'user'
            ? ['created_by' => $user->id]
            : [];

        $counts = [
            'pending'      => Booking::where($filter)->where('booking_status', 'pending')->count(),
            'confirmed'    => Booking::where($filter)->where('booking_status', 'confirmed')->count(),
            'cancelled'    => Booking::where($filter)->where('booking_status', 'cancelled')->count(),
            'checked_in'   => Booking::where($filter)->where('booking_status', 'checked_in')->count(),
            'checked_out'  => Booking::where($filter)->where('booking_status', 'checked_out')->count(),
        ];

        return view('admin.dashboard', compact('counts'));
    }
}
