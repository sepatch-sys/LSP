<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\TypeRoom;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('images')->get();
        return view('room.index', compact('rooms'));
    }

    public function create()
    {
        $typeRooms = TypeRoom::all();
        return view('room.create', compact('typeRooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_room_id' => 'required|exists:type_rooms,id',
            'room_number' => 'required|string|max:255',
            'price_night' => 'required|numeric',
            'status' => 'required|in:' . implode(',', array_keys(Room::getStatusLabel())),
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room = Room::create([
            'type_room_id' => $request->type_room_id,
            'room_number' => $request->room_number,
            'price_night' => $request->price_night,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $room->images()->create(['image_path' => $path]);
            }
        }
        return redirect()->route('room.index')->with('success', 'Room created successfully.');
    }

    public function show($id)
    {
        $room = Room::with('images', 'typeRoom')->findOrFail($id);
        
        $typeRooms = TypeRoom::all();
    
        return view('room.show', compact('room', 'typeRooms'));
    }

    public function edit($id)
    {
        $room = Room::with('images', 'typeRoom')->findOrFail($id);
        
        $typeRooms = TypeRoom::all();
    
        return view('room.edit', compact('room', 'typeRooms'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'type_room_id' => 'required|exists:type_rooms,id',
            'room_number' => 'required|string|max:255',
            'price_night' => 'required|numeric',
            'status' => 'required|in:' . implode(',', array_keys(Room::getStatusLabel())),
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room = Room::findOrFail($id);
        $room->update($request->all());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $room->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('room.index')->with('success', 'Room updated successfully.');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->images()->delete();
        $room->delete();

        return redirect()->route('room.index')->with('success', 'Room deleted successfully.');
    }
    public function changeStatus(Request $request, Room $room)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Room::getStatusLabel())),
        ]);
        $room->updateStatus($request->status);

        return redirect()->route('room.index')->with('success', 'Room status updated successfully.');
    }
}
