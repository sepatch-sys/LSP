<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('room.update', $room->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="type_room_id" class="block text-sm font-medium text-gray-700">{{ __('Type of Room') }}</label>
                                <select id="type_room_id" name="type_room_id" class="block w-full mt-1 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    @foreach ($typeRooms as $typeRoom)
                                        <option value="{{ $typeRoom->id }}" {{ $room->type_room_id == $typeRoom->id ? 'selected' : '' }}>
                                            {{ $typeRoom->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_room_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="room_number" class="block text-sm font-medium text-gray-700">{{ __('Room Number') }}</label>
                                <input id="room_number" type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" class="block w-full mt-1 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('room_number')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="price_night" class="block text-sm font-medium text-gray-700">{{ __('Price per Night') }}</label>
                            <input id="price_night" type="number" name="price_night" value="{{ old('price_night', $room->price_night) }}" class="block w-full mt-1 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            @error('price_night')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                            <select id="status" name="status" class="block w-full mt-1 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @foreach (App\Models\Room::getStatusLabel() as $key => $value)
                                    <option value="{{ $key }}" {{ $room->status == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                            <textarea id="description" name="description" class="block w-full mt-1 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="images" class="block text-sm font-medium text-gray-700">{{ __('Room Images') }}</label>
                            <input type="file" name="images[]" id="images" class="block w-full mt-1" multiple>
                            @error('images.*')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <h3 class="font-medium text-lg text-gray-700">{{ __('Current Images') }}</h3>
                            <div class="grid grid-cols-3 gap-4 mt-2">
                                @foreach ($room->images as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Room Image" class="w-full h-32 object-cover rounded-md shadow-md">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 text-white rounded-md p-2 hover:bg-blue-600">{{ __('Save Changes') }}</button>
                            <a href="{{ route('room.index') }}" class="text-gray-600 hover:text-gray-800">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
