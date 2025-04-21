<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            Room List
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-4">Room List</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">{{ session('success') }}</div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('room.create') }}" class="custom-button">+ Create Room</a>
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">Image</th>
                        <th class="border px-4 py-2 text-left">Room (Number)</th>
                        <th class="border px-4 py-2 text-left">Price</th>
                        <th class="border px-4 py-2 text-center">Status</th>
                        <th class="border px-4 py-2 text-left">Description</th>
                        <th class="border px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">
                                @if ($room->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $room->images->first()->image_path) }}"
                                        alt="{{ $room->room_number }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <span>No image</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $room->room_number }}</td>
                            <td class="border px-4 py-2">Rp {{ number_format($room->price_night, 2, ',', '.') }}</td>

                            <td class="border px-4 py-2 text-center">
                                <select class="status-selector border rounded px-2 py-1"
                                    data-room-id="{{ $room->id }}">
                                    @foreach (\App\Models\Room::getStatusLabel() as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ $room->status === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="border px-4 py-2">{{ $room->description }}</td>
                            <td class="border px-4 py-2 text-center space-x-2">
                                <a href="{{ route('room.edit', $room->id) }}" class="edit-button">Edit</a>

                                <a href="{{ route('room.show', $room->id) }}" class="show-button">Show</a>

                                <form action="{{ route('room.destroy', $room->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button"
                                        onclick="return confirm('Are you sure you want to delete this room?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.status-selector').forEach(select => {
            select.addEventListener('change', function() {
                let roomId = this.getAttribute('data-room-id');
                let newStatus = this.value;

                fetch(`/rooms/${roomId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
    <style>
        .custom-button {
            background-color: #3498DB;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .custom-button:hover {
            background-color: #2980B9;
            color: aliceblue;
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .edit-button:hover {
            background-color: #45A049;
            color: aliceblue
        }

        .show-button {
            background-color: #2196F3;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .show-button:hover {
            background-color: #0B78D5;
            color: aliceblue;
        }

        .delete-button {
            background-color: #F44336;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #DA190B;
            color: aliceblue;
        }
    </style>
</x-app-layout>
