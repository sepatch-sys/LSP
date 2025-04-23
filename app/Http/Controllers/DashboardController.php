<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ? now()->parse($request->date)->format('Y-m-d') : now()->format('Y-m-d');
        
        $topRooms = Reservation::select('room_id', DB::raw('count(*) as total'))
            ->groupBy('room_id')
            ->orderByDesc('total')
            ->take(3)
            ->get();

        $topRoomsDetail = $topRooms->map(function ($item) {
            $room = Room::find($item->room_id);
            return [
                'room_number' => $room?->room_number ?? 'Unknown',
                'count' => $item->total,
            ];
        });

        $popularRoom = $topRoomsDetail->first();

        $activeReservations = Reservation::whereIn('status_reservation', [
            Reservation::STATUS_RESERVATION_PENDING,
            Reservation::STATUS_RESERVATION_CHECKIN
        ])->count();

        $totalIncome = Reservation::when($date, function ($query) use ($date) {
            if ($date === now()->format('Y-m-d')) {
                return $query->whereMonth('check_in', now()->month);
            } else {
                return $query->whereDate('check_in', $date);
            }
        })
        ->whereIn('status_payment', [
            Reservation::STATUS_CONFIRMED,
        ])
        ->sum('total_price');

        return view('dashboard', [
            'popularRoom' => $popularRoom,
            'topRooms' => $topRoomsDetail,
            'activeReservations' => $activeReservations,
            'totalIncome' => $totalIncome
        ]);
    }
}
