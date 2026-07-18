<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        
                        <!-- Card Jumlah Buku -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="text-blue-500 text-sm font-bold uppercase tracking-wider">Jumlah Judul Buku</div>
                                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBooks }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Jumlah Anggota -->
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="text-green-500 text-sm font-bold uppercase tracking-wider">Jumlah Anggota</div>
                                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $totalMembers }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Pinjaman Aktif -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="text-yellow-600 text-sm font-bold uppercase tracking-wider">Pinjaman Aktif</div>
                                    <div class="text-3xl font-bold text-gray-800 mt-1">{{ $activeBorrowings }}</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Garis Pemisah -->
                    <hr class="mb-6 border-gray-200">

                    <!-- Grafik Mingguan -->
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Grafik Peminjaman 4 Minggu Terakhir</h3>
                    <div style="position: relative; height:40vh; width:100%" class="mb-10">
                        <canvas id="weeklyChart"></canvas>
                    </div>

                    <!-- Garis Pemisah -->
                    <hr class="mb-6 border-gray-200">

                    <!-- Grafik Harian -->
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Grafik Peminjaman 7 Hari Terakhir</h3>
                    <div style="position: relative; height:40vh; width:100%">
                        <canvas id="dailyChart"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Memanggil library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Konfigurasi grafik
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            };

            // Grafik Mingguan
            const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
            new Chart(weeklyCtx, {
                type: 'bar', 
                data: {
                    labels: {!! json_encode($labelsWeekly) !!},
                    datasets: [{
                        label: 'Peminjaman Mingguan',
                        data: {!! json_encode($dataWeekly) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: commonOptions
            });

            // Grafik Harian
            const dailyCtx = document.getElementById('dailyChart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'bar', 
                data: {
                    labels: {!! json_encode($labelsDaily) !!},
                    datasets: [{
                        label: 'Peminjaman Harian',
                        data: {!! json_encode($dataDaily) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: commonOptions
            });

        });
    </script>
</x-app-layout>