<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4 flex items-center gap-4">
                <div>
                    <label for="date" class="text-sm text-gray-600">Pilih Tanggal</label>
                    <input type="date" id="date" name="date" value="{{ request('date') }}" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Filter
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-sm text-gray-500">Kamar Terpopuler</h3>
                    @if($popularRoom)
                        <p class="text-xl font-bold text-blue-600 mt-2">
                            {{ $popularRoom['room_number'] }} 
                            <span class="text-sm text-gray-400">({{ $popularRoom['count'] }}x reservasi)</span>
                        </p>
                    @else
                        <p class="text-gray-400 mt-2">Belum ada data reservasi.</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-sm text-gray-500">Reservasi Aktif</h3>
                    <p class="text-xl font-bold text-green-600 mt-2">
                        {{ $activeReservations }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-sm text-gray-500">Total Pendapatan
                        @if(request('date'))
                            ({{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }})
                        @else
                            (Bulan Ini)
                        @endif
                    </h3>
                    <p class="text-xl font-bold text-emerald-600 mt-2">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Top 3 Kamar Terpopuler</h3>
                <table class="min-w-full table-auto text-left border border-gray-200">
                    <thead class="bg-gray-100 text-sm font-semibold text-gray-600">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Kamar</th>
                            <th class="px-4 py-2 border">Total Reservasi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($topRooms as $index => $room)
                            <tr class="border-t">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $room['room_number'] }}</td>
                                <td class="px-4 py-2 border">{{ $room['count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-xl shadow p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Grafik Kamar Terpopuler</h3>
                <canvas id="roomChart" height="100"></canvas>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('roomChart').getContext('2d');
        const roomChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topRooms->pluck('room_number')) !!},
                datasets: [{
                    label: 'Total Reservasi',
                    data: {!! json_encode($topRooms->pluck('count')) !!},
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
