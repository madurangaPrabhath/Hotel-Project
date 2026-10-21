<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

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

    public function update_room(Request $request, int $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return redirect()->route('view_room')->with('error', 'Room not found.');
        }

        $validator = Validator::make($request->all(), [
            'room_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'wifi' => 'required|in:yes,no',
            'room_type' => 'required|in:regular,premium,deluxe',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'room_title.required' => 'Room Title is required.',
            'price.required' => 'Price is required.',
            'wifi.required' => 'Please select the Free Wifi option.',
            'room_type.required' => 'Please select a Room Type.',
            'image.mimes' => 'The image must be a jpeg, png, jpg or gif file.',
            'image.max' => 'The image may not be greater than 2 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('view_room')
                ->withInput()
                ->withErrors($validator)
                ->with('edit_room_id', $id);
        }

        $validated = $validator->validated();

        $room->room_title = $validated['room_title'];
        $room->description = $validated['description'];
        $room->price = $validated['price'];
        $room->wifi = $validated['wifi'];
        $room->room_type = $validated['room_type'];

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
