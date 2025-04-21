<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Room') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Create Room</h2>

        <form action="{{ route('room.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="type_room_id" class="block text-sm font-medium text-gray-700">Type Room</label>
                <select name="type_room_id" id="type_room_id"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">TypeRoom</option>
                    @foreach ($typeRooms as $type)
                        <option value="{{ $type->id }}" {{ old('type_room_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('type_room_id')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                <input type="text" name="room_number" id="room_number"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required value="{{ old('room_number') }}">
                @error('room_number')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price_night" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price_night" id="price_night"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required value="{{ old('price_night') }}">
                @error('price_night')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Room Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach (App\Models\Room::getStatusLabel() as $key => $value)
                        <option value="{{ $key }}" {{ old('status', 'tersedia') == $key ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="images" class="block text-sm font-medium text-gray-700">Upload Images</label>
                <input type="file" name="images[]" id="images"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    accept="image/*" onchange="previewImages(event)" multiple>
                @error('images.*')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <div id="imagePreview" class="grid grid-cols-4 gap-2 mt-2"></div>
            </div>

            <div class="flex items-center space-x-2 mt-4">
                <button type="submit" class="create-button">
                    <i class="fas fa-save"></i> <span class="create-button">Create</span>
                </button>
                <a href="{{ route('room.index') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i> <span class="back-button">Back</span>
                </a>
            </div>
        </form>
    </div>

    <script>
        function previewImages(event) {
            let previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';

            let files = event.target.files;
            if (files) {
                for (let i = 0; i < files.length; i++) {
                    let file = files[i];
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.className = "w-10 h-10 object-cover rounded-lg shadow";
                        previewContainer.appendChild(imgElement);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>

    <style>
        .create-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #2196F3;
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .create-button:hover {
            background-color: #0B78D5;
            color: aliceblue;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #D1D1D1;
            color: #333;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #B0B0B0;
            color: #222;
        }
    </style>
</x-app-layout>
