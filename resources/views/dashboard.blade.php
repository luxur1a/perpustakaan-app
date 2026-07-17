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
                    <h3 class="text-lg font-bold mb-4">Grafik Peminjaman 7 Hari Terakhir</h3>
                    
                    <!-- Wadah untuk grafik -->
                    <div style="position: relative; height:40vh; width:100%">
                        <canvas id="peminjamanChart"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Memanggil library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('peminjamanChart').getContext('2d');
            
            // Mengambil data dari Controller yang dikirim via compact()
            const labels = {!! json_encode($labels) !!};
            const data = {!! json_encode($data) !!};

            new Chart(ctx, {
                type: 'bar', // Bisa diganti 'line' jika ingin grafik garis
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Angka di sumbu Y tidak pakai desimal
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>