<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        return view('reservation');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'date' => 'required|date',
            'time' => 'required',
            'guests' => 'required|string'
        ]);

        DB::table('reservations')->insert([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'guests' => $request->guests,
            'status' => 'pending',
            'created_at' => now()
        ]);

        return redirect()->route('reservation')->with('success', 'Reservation submitted successfully!');
    }
}
