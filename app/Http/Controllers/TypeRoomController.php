<?php

namespace App\Http\Controllers;

use App\Models\TypeRoom;
use Illuminate\Http\Request;

class TypeRoomController extends Controller
{
    public function index()
    {
        $typerooms = TypeRoom::all();
        return view('typeroom.index', compact('typerooms'));
    }

    public function create()
    {
        return view('typeroom.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'facilitie' => 'required|string|max:255',
        ]);

        TypeRoom::create($request->all());

        return redirect()->route('type-room.index')->with('success', 'Type Room created successfully.');
    }
    public function edit($id)
    {
        $typeroom = TypeRoom::findOrFail($id);
        return view('typeroom.edit', compact('typeroom'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'facilitie' => 'required|string|max:255',
        ]);

        $typeroom = TypeRoom::findOrFail($id);
        $typeroom->update($request->all());

        return redirect()->route('type-room.index')->with('success', 'Type Room updated successfully.');
    }
    public function destroy($id)
    {
        $typeroom = TypeRoom::findOrFail($id);
        $typeroom->delete();

        return redirect()->route('type-room.index')->with('success', 'Type Room deleted successfully.');
    }
}
