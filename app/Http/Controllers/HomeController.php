<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;

class HomeController extends Controller
{
    public function room_details(int $id)
    {
        $room = \App\Models\Room::findOrFail($id);
        return view('home.room_details', compact('room'));
    }
}
