<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminReservationController extends Controller
{
    public function index()
{
    $reservations = Reservation::latest()->paginate(10);
    $notifications = Auth::user()->unreadNotifications;

    return view('admin.reservations.index', compact('reservations', 'notifications'));
}
}
