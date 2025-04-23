<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) 
    {
        $rooms = Room::with('typeRoom', 'images')
            ->when($request->filled('type_room'), function ($query) use ($request) {
                $query->whereHas('typeRoom', function ($subQuery) use ($request) {
                    $subQuery->where('name', 'like', '%' . $request->type_room . '%');
                });
            })
            ->when($request->filled('min_price'), function ($query) use ($request) {
                    $query->where('price_night', '>=', $request->min_price);
            })
            ->when($request->filled('max_price'), function ($query) use ($request) {
                    $query->where('price_night', '<=', $request->max_price);
            });
    
        if ($request->filled('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $rooms = $rooms->join('type_rooms', 'rooms.type_room_id', '=', 'type_rooms.id')
                ->orderBy('type_rooms.price', $request->sort)
                ->select('rooms.*');
        }
    
        return view('welcome', ['rooms' => $rooms,]);
    }
    

    public function show($id)
    {
        $rooms = Room::with('images', 'typeRoom')->findOrFail($id);
        return view('homeRoom.show', compact('rooms'));
    }

    public function reservation($id)
    {
        $rooms = Room::with('typeRoom', 'images')->findOrFail($id);

        return view('homeRoom.reservation', compact('rooms'));
    }
}
