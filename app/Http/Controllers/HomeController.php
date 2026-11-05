<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;

class HomeController extends Controller
{
    public function room_details(int $id)
    {
        try {
            $room = \App\Models\Room::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }

        return view('home.room_details', compact('room'));
    }

    public function add_booking(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $room = Room::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Room not found.');
        }

        $conflict = \App\Models\Booking::where('room_id', $room->id)
            ->where('start_date', '<=', $request->input('end_date'))
            ->where('end_date', '>=', $request->input('start_date'))
            ->exists();

        if ($conflict) {
            return redirect()->back()->with('error', 'This room is already booked');
        }

        try {
            $booking = new \App\Models\Booking();
            $booking->room_id = $room->id;
            $booking->name = $request->input('name');
            $booking->email = $request->input('email');
            $booking->contact_number = $request->input('contact_number');
            $booking->start_date = $request->input('start_date');
            $booking->end_date = $request->input('end_date');
            $booking->save();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to create booking. Please try again.');
        }

        return redirect()->back()->with('success', 'Booking added successfully!');
    }
}
