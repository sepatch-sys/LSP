<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            Reservation List
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-4">Reservation List</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">Customer Name</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Phone</th>
                        <th class="border px-4 py-2">Check-in</th>
                        <th class="border px-4 py-2">Check-out</th>
                        <th class="border px-4 py-2">Total Price</th>
                        <th class="border px-4 py-2">Payment Status</th>
                        <th class="border px-4 py-2">Reservation Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $reservation->name }}</td>
                            <td class="border px-4 py-2">{{ $reservation->email }}</td>
                            <td class="border px-4 py-2">{{ $reservation->phone }}</td>
                            <td class="border px-4 py-2">{{ $reservation->check_in }}</td>
                            <td class="border px-4 py-2">{{ $reservation->check_out }}</td>
                            <td class="border px-4 py-2">Rp {{ number_format($reservation->total_price, 2, ',', '.') }}
                            </td>

                            <td class="border px-4 py-2">
                                <select class="status-selector border rounded px-2 py-1"
                                    data-reservation-id="{{ $reservation->id }}" data-type="payment">
                                    @foreach (\App\Models\Reservation::getStatusPayment() as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ $reservation->status_payment === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="border px-4 py-2">
                                <select class="status-selector border rounded px-2 py-1"
                                    data-reservation-id="{{ $reservation->id }}" data-type="reservation">
                                    @foreach (\App\Models\Reservation::getStatusReservation() as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ $reservation->status_reservation === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
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
                const reservationId = this.getAttribute('data-reservation-id');
                const newStatus = this.value;
                const type = this.getAttribute('data-type');

                fetch(`/reservations/${reservationId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            type: type,
                            status: newStatus
                        })
                    })
                    .then(response => response.ok ? response.text() : Promise.reject(response))
                    .then(message => {
                        alert('Status berhasil diperbarui.');
                    })
                    .catch(error => {
                        alert('Gagal mengubah status.');
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</x-app-layout>
