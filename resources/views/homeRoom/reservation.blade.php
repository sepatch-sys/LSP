<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">
            <div class="md:w-1/2 p-6">
                <h1 class="text-2xl font-bold text-gray-800">Room {{ $rooms->room_number }}</h1>
                <p class="text-gray-500 text-sm">Type: {{ optional($rooms->typeRoom)->name ?? 'N/A' }}</p>

                <p class="mt-2 text-lg font-semibold text-orange-500">
                    Rp {{ number_format($rooms->price_night, 0, ',', '.') }} / night
                </p>

                <div class="mt-4">
                    <h3 class="text-md font-semibold text-gray-700">Facilities:</h3>
                    @if ($rooms->typeRoom && $rooms->typeRoom->facilitie)
                        <ul class="mt-2 grid grid-cols-2 gap-2 text-gray-600">
                            @foreach (explode(',', $rooms->typeRoom->facilitie) as $facility)
                                <li class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ trim($facility) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No Facilities Available</p>
                    @endif
                </div>

                <form id="reservation-form" class="mt-6 space-y-4">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $rooms->id }}">
                    <input type="hidden" id="total_price" name="total_price" value="">

                    <div>
                        <label class="block text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div>
                        <label class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div>
                        <label class="block text-gray-700">Phone Number</label>
                        <input type="text" id="phone" name="phone" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div class="flex space-x-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700">Check-in</label>
                            <input type="date" id="check_in" name="check_in" required
                                class="w-full px-4 py-2 border rounded-md">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700">Check-out</label>
                            <input type="date" id="check_out" name="check_out" required
                                class="w-full px-4 py-2 border rounded-md">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700">Guest Count</label>
                        <input type="number" id="guest_count" name="guest_count" min="1" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div>
                        <label class="block text-gray-700">Total Price</label>
                        <input type="text" id="total_price_display"
                            class="w-full px-4 py-2 border rounded-md bg-gray-100" disabled>
                    </div>

                    <div class="flex justify-between items-center gap-4">
                        <a href="{{ route('home.index') }}" 
                           class="w-full text-center bg-gray-300 text-gray-800 py-2 rounded-md hover:bg-gray-400">
                            Return
                        </a>
                    
                        <button type="button" id="pay-button"
                            class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                            Confirm Reservation
                        </button>
                    </div>
                </form>
            </div>

            <div class="md:w-1/2 p-4 flex justify-center items-center">
                @if ($rooms->images->count() > 0)
                    <img src="{{ $rooms->images->isNotEmpty() ? asset('storage/' . $rooms->images->first()->image_path) : asset('default-image.jpg') }}"
                        alt="Room Image" class="w-full h-64 object-cover rounded-md shadow-md">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-md flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script>
        document.getElementById('check_in').addEventListener('change', calculateTotal);
        document.getElementById('check_out').addEventListener('change', calculateTotal);
        document.getElementById('guest_count').addEventListener('input', calculateTotal);

        function calculateTotal() {
            let checkInDate = new Date(document.getElementById('check_in').value);
            let checkOutDate = new Date(document.getElementById('check_out').value);
            let pricePerNight = {{ $rooms->price_night }};

            if (checkInDate && checkOutDate && checkOutDate > checkInDate) {
                let totalDays = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
                let totalPrice = totalDays * pricePerNight;

                document.getElementById('total_price').value = totalPrice;
                document.getElementById('total_price_display').value = 'Rp ' + totalPrice.toLocaleString('id-ID');
            }
        }

        document.getElementById('pay-button').addEventListener('click', function(e) {
            e.preventDefault();

            let formData = new FormData(document.getElementById('reservation-form'));

            fetch("{{ route('reservation.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert("Payment Success!");
                                window.location.href = "{{ route('home.index') }}";
                            },
                            onPending: function(result) {
                                alert("Waiting for payment...");
                            },
                            onError: function(result) {
                                alert("Payment Failed!");
                            }
                        });
                    } else {
                        alert("Failed to get Snap Token!");
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    </script>

</x-app-layout>