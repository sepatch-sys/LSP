<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        @if ($rooms->images->count())
            <div class="rounded-2xl overflow-hidden shadow-lg mb-8">
                <img src="{{ asset('storage/' . $rooms->images->first()->image_path) }}" alt="Gambar Kamar"
                    class="w-full h-80 object-cover rounded-xl">
            </div>
        @endif

        <div class="bg-white p-6 rounded-2xl shadow-md space-y-4">
            <h2 class="text-3xl font-semibold">Kamar {{ $rooms->room_number }} - {{ $rooms->typeRoom->name }}</h2>
            <p class="text-gray-600">Fasilitas: {{ $rooms->typeRoom->facilitie ?? 'Informasi tidak tersedia' }}</p>
            <p class="text-xl font-bold" style="color: #2980B9">Harga: Rp
                {{ number_format($rooms->price_night, 0, ',', '.') }} / malam</p>
            <p class="mt-1">
                Status:
                <span
                    class="
                    font-semibold 
                    {{ $rooms->status === \App\Models\Room::STATUS_AVAILABLE
                        ? 'text-green-600'
                        : ($rooms->status === \App\Models\Room::STATUS_UNAVAILABLE
                            ? 'text-red-600'
                            : ($rooms->status === \App\Models\Room::STATUS_CLEANING
                                ? 'text-yellow-500'
                                : ($rooms->status === \App\Models\Room::STATUS_MAINTENANCE
                                    ? 'text-orange-500'
                                    : 'text-gray-500'))) }}">
                    {{ \App\Models\Room::getStatusLabel()[$rooms->status] }}
                </span>
            </p>

            <div class="flex gap-4 mt-4">
                <a href="{{ route('home.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Kembali</a>

                @if ($rooms->status === \App\Models\Room::STATUS_AVAILABLE)
                    <form action="{{ route('reservation.room', $rooms->id) }}">
                        @csrf
                        <button type="submit" class="pesan-button">Pesan Sekarang</button>
                    </form>
                @else
                    <button disabled class="pesan-button opacity-50 cursor-not-allowed">Tidak Tersedia</button>
                @endif
            </div>
        </div>
    </div>

    <style>
        .pesan-button {
            background-color: #3498DB;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .pesan-button:hover {
            background-color: #2980B9;
            color: aliceblue;
        }
    </style>
</x-app-layout>
