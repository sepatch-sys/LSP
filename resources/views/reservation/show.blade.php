<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Reservasi Anda</h2>

        <div class="grid grid-cols-1 gap-6">
            @forelse ($reservations as $reservation)
                <div class="border rounded-2xl overflow-hidden shadow-sm flex gap-6 p-4 bg-white">
                    <img src="{{ $reservation->room->images->first() ? asset('storage/' . $reservation->room->images->first()->image_path) : asset('storage/default-room.jpg') }}"
                        alt="Kamar {{ $reservation->room->room_number }}"
                        class="w-1/3 rounded-xl object-cover h-48">
                    
                    <div class="flex flex-col justify-between w-2/3">
                        <div>
                            <h2 class="text-xl font-semibold mb-1">
                                Kamar {{ $reservation->room->room_number }} - {{ $reservation->room->typeRoom->name }}
                            </h2>
                            <p class="text-gray-600 mb-2">
                                Fasilitas: {{ $reservation->room->typeRoom->facilitie ?? '-' }}
                            </p>
                            <p class="text-lg font-bold text-blue-600">
                                Total: Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                            </p>
                            <p class="text-gray-700 mt-1">Check-in: <strong>{{ $reservation->check_in }}</strong></p>
                            <p class="text-gray-700">Check-out: <strong>{{ $reservation->check_out }}</strong></p>
                            <p class="text-gray-700">Jumlah Tamu: <strong>{{ $reservation->guest_count }}</strong></p>
                            <p class="mt-1">
                                Status Pembayaran:
                                <span class="inline-block text-sm px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                                    {{ \App\Models\Reservation::getStatusPayment()[$reservation->status_payment] ?? '-' }}
                                </span>
                            </p>
                            <p>
                                Status Reservasi:
                                <span class="inline-block text-sm px-2 py-1
                                    {{ $reservation->status_reservation === \App\Models\Reservation::STATUS_RESERVATION_CANCELLED ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}
                                    rounded-full">
                                    {{ \App\Models\Reservation::getStatusReservation()[$reservation->status_reservation] ?? '-' }}
                                </span>
                            </p>
                        </div>

                        <div class="flex gap-3 mt-4">
                            <a href="{{ route('home.show', $reservation->room->id) }}" class="px-4 py-2 border rounded-lg">
                                Lihat Detail Kamar
                            </a>

                            @if ($reservation->status_reservation !== \App\Models\Reservation::STATUS_RESERVATION_CANCELLED)
                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan reservasi ini?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="filter-pesan-button bg-red-600 hover:bg-red-700">
                                        Batalkan Reservasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Anda belum memiliki reservasi kamar.</p>
            @endforelse
        </div>
    </div>

    <style>
        .filter-pesan-button {
            background-color: #3498DB;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        .filter-pesan-button:hover {
            background-color: #2980B9;
            color: aliceblue;
        }
    </style>
</x-app-layout>
