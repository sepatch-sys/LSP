<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('Room Number') }}</h3>
                            <p class="text-lg text-gray-600">{{ $room->room_number }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('Type of Room') }}</h3>
                            <p class="text-lg text-gray-600">{{ $room->typeRoom->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('Price per Night') }}</h3>
                            <p class="text-lg text-gray-600">{{ number_format($room->price_night, 2, ',', '.') }} {{ __('IDR') }}</p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('Status') }}</h3>
                            <p class="text-lg text-gray-600">{{ App\Models\Room::getStatusLabel()[$room->status] }}</p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('Description') }}</h3>
                            <p class="text-lg text-gray-600">{{ $room->description ?? __('No description available.') }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">{{ __('Room Images') }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($room->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Room Image" class="w-full h-64 object-cover rounded-md shadow-md cursor-pointer transition-all duration-300 transform hover:scale-105" data-image="{{ asset('storage/' . $image->image_path) }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
                        <div class="relative">
                            <button id="closeModal" class="absolute top-0 right-0 p-2 text-white">X</button>
                            <img id="modalImage" src="" alt="Zoomed Image" class="w-full max-w-2xl h-auto rounded-md shadow-lg">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('room.index') }}" class="text-blue-500 hover:text-blue-700 text-lg">{{ __('Back to Rooms List') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.cursor-pointer').forEach(image => {
            image.addEventListener('click', function() {
                const imageUrl = this.getAttribute('data-image');
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                modalImage.src = imageUrl;
                modal.classList.remove('hidden');
            });
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('imageModal').classList.add('hidden');
        });
    </script>
</x-app-layout>
