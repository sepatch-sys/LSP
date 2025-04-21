<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Services\MidtransService;

class ReservationController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index()
    {
        $reservations = Reservation::all();

        return view('reservation.index', compact('reservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'guest_count' => 'required|integer|min:1',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room = Room::find($request->room_id);
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        $existingReservation = Reservation::where('room_id', $room->id)
        ->where('status_reservation', '!=', Reservation::STATUS_RESERVATION_CANCELLED)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);       
                    });
            })
            ->exists();

        if ($existingReservation) {
            return response()->json(['error' => 'Tanggal yang dipilih sudah dipesan. Silakan pilih tanggal lain.'], 400);
        }

        $totalNights = (new \DateTime($checkOut))->diff(new \DateTime($checkIn))->days;
        $totalPrice = $totalNights * $room->price_night;

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'guest_count' => $request->guest_count,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
        ]);

        $snapToken = $this->midtransService->createTransaction($reservation);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function userReservations()
    {
        $reservations = Reservation::where('user_id', auth()->id())
            ->where('status_reservation', '!=', Reservation::STATUS_RESERVATION_CANCELLED)
            ->with('room.images', 'room.typeRoom')
            ->get();

        return view('reservation.show', compact('reservations'));
    }

    public function changeStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'type' => 'required|in:payment,reservation',
            'status' => 'required|string',
        ]);

        try {
            if ($request->type === 'payment') {
                $reservation->updateStatusPayment($request->status);
            } elseif ($request->type === 'reservation') {
                $reservation->updateStatusReservation($request->status);
            }

            return response()->json(['message' => 'Status berhasil diperbarui.']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->updateStatusReservation(Reservation::STATUS_RESERVATION_CANCELLED);

        if ($reservation->status_payment === Reservation::STATUS_CONFIRMED) {
            $reservation->updateStatusPayment(Reservation::STATUS_REFUNDED);
        } else {
            $reservation->updateStatusPayment(Reservation::STATUS_CANCELLED);
        }

        return redirect()->route('reservations.user')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
