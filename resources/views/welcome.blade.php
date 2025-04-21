<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">

        <img src="{{ asset('storage/images/hotel-3.jpg') }}" alt="Banner Hotel" class="rounded-2xl w-full mb-8 shadow-lg object-cover h-64">

        <form method="GET" action="{{ route('home.index') }}" class="flex items-center gap-4 mb-8 flex-wrap">
            <div class="flex items-center gap-2">
                <label class="font-semibold">Harga:</label>
                <input type="number" name="min_price" placeholder="Min Rp" class="border rounded-lg px-4 py-2 w-32" value="{{ request('min_price') }}">
                <input type="number" name="max_price" placeholder="Max Rp" class="border rounded-lg px-4 py-2 w-32" value="{{ request('max_price') }}">
            </div>

            <select name="sort" class="border rounded-lg px-4 py-2">
                <option value="">Urutkan</option>
                <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Harga Tertinggi</option>
            </select>

            <select name="type_room" class="border rounded-lg px-4 py-2">
                <option value="">Pilih Tipe Kamar</option>
                <option value="Reguler" {{ request('type_room') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                <option value="Deluxe" {{ request('type_room') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                <option value="Suite" {{ request('type_room') == 'Suite' ? 'selected' : '' }}>Suite</option>
            </select>

            <button type="submit" class="filter-pesan-button">Filter</button>
        </form>

        <div class="grid grid-cols-1 gap-6">
            @forelse ($rooms->get() as $room)
                <div class="border rounded-2xl overflow-hidden shadow-sm flex gap-6 p-4 bg-white">
                    <img src="{{ asset('storage/' . $room->images->first()->image_path) }}" alt="Kamar {{ $room->room_number }}" class="w-1/3 rounded-xl object-cover h-48">
                    <div class="flex flex-col justify-between w-2/3">
                        <div>
                            <h2 class="text-xl font-semibold mb-1">Kamar {{ $room->room_number }} - {{ $room->typeRoom->name }}</h2>
                            <p class="text-gray-600 mb-2">Fasilitas: {{ $room->typeRoom->facilitie }}</p>
                            <p class="text-lg font-bold" style="color: #2980B9">Harga: Rp {{ number_format($room->price_night, 0, ',', '.') }} / malam</p>
                            <p class="mt-1">
                                Status:
                                <span
                                    class="
                                    font-semibold 
                                    {{ $room->status === \App\Models\Room::STATUS_AVAILABLE
                                        ? 'text-green-600'
                                        : ($room->status === \App\Models\Room::STATUS_UNAVAILABLE
                                            ? 'text-red-600'
                                            : ($room->status === \App\Models\Room::STATUS_CLEANING
                                                ? 'text-yellow-500'
                                                : ($room->status === \App\Models\Room::STATUS_MAINTENANCE
                                                    ? 'text-orange-500'
                                                    : 'text-gray-500'))) }}">
                                    {{ \App\Models\Room::getStatusLabel()[$room->status] }}
                                </span>
                            </p>           
                        </div>
                        <div class="flex gap-3 mt-4">
                            <a href="{{ route('home.show', $room->id) }}" class="px-4 py-2 border rounded-lg">Detail</a>
                            @if ($room->status === \App\Models\Room::STATUS_AVAILABLE)
                            <a href="{{ route('reservation.room', $room->id) }}" class="filter-pesan-button">Pesan</a>
                        @else
                            <button disabled class="filter-pesan-button opacity-50 cursor-not-allowed">Tidak Tersedia</button>
                        @endif                        
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Tidak ada kamar yang tersedia.</p>
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
        }

        .filter-pesan-button:hover {
            background-color: #2980B9;
            color: aliceblue;
        }
    </style>
</x-app-layout>
