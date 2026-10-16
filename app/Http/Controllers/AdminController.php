<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use App\Models\Room;

class AdminController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $usertype = Auth::user()->usertype;

            if ($usertype == 'user') 
            {
                return view('home.index');
            }
            elseif ($usertype == 'admin')
            {
                return view('admin.index');
            }
        }
        else
        {
            return redirect()->back();
        }
    }

    public function home()
    {
        return view('home.index');
    }

    public function create_room()
    {
        return view('admin.create_room');
    }

    public function add_room(Request $request)
    {
        $room = new Room();

        $room->room_title = $request->input('room_title');
        $room->description = $request->input('description');
        $room->price = $request->input('price');
        $room->wifi = $request->input('wifi');
        $room->room_type = $request->input('room_type');

        if ($request->hasFile('image')) 
        {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/rooms/' . $filename;
            $file->move(public_path('uploads/rooms'), $filename);
            $room->image = $filePath;
        }

        $room->save();

        return redirect()->back()->with('success', 'Room added successfully.');
    }

    public function view_room()
    {
        $rooms = Room::all();
        return view('admin.view_room', compact('rooms'));
    }

    public function delete_room(int $id)
    {
        $room = Room::find($id);

        if ($room) {
            if ($room->image && file_exists(public_path($room->image))) {
                unlink(public_path($room->image));
            }

            $room->delete();

            return redirect()->back()->with('success', 'Room deleted successfully.');
        }

        return redirect()->back()->with('error', 'Room not found.');
    }

    public function edit_room(int $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }

        return view('admin.edit_room', compact('room'));
    }

    public function update_room(Request $request, int $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }

        $request->validate([
            'room_title' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'room_type' => 'required|in:regular,premium,deluxe',
            'wifi' => 'required|in:yes,no',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room->room_title = $request->input('room_title');
        $room->description = $request->input('description');
        $room->price = $request->input('price');
        $room->wifi = $request->input('wifi');
        $room->room_type = $request->input('room_type');

        if ($request->hasFile('image')) {
            if ($room->image && file_exists(public_path($room->image))) {
                unlink(public_path($room->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/rooms/' . $filename;
            $file->move(public_path('uploads/rooms'), $filename);
            $room->image = $filePath;
        }

        $room->save();

        return redirect()->route('view_room')->with('success', 'Room updated successfully.');
    }
}
