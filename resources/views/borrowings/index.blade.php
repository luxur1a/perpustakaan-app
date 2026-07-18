<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- 3 Kotak Informasi (Cards) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        
                        <!-- Card Pinjaman Aktif -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded shadow-sm">
                            <div class="text-blue-500 text-sm font-bold uppercase tracking-wider">Pinjaman Aktif</div>
                            <div class="text-3xl font-bold text-gray-800 mt-1">{{ $activeBorrowings }}</div>
                        </div>

                        <!-- Card Jatuh Tempo Hari Ini -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded shadow-sm">
                            <div class="text-yellow-600 text-sm font-bold uppercase tracking-wider">Jatuh Tempo Hari Ini</div>
                            <div class="text-3xl font-bold text-gray-800 mt-1">{{ $dueTodayBorrowings }}</div>
                        </div>

                        <!-- Card Overdue -->
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                            <div class="text-red-500 text-sm font-bold uppercase tracking-wider">Overdue (> 7 Hari)</div>
                            <div class="text-3xl font-bold text-red-600 mt-1">{{ $overdueBorrowings }}</div>
                        </div>

                    </div>

                    <hr class="mb-6 border-gray-200">

                    <!-- Header Aksi: Form Pencarian & Tombol Tambah -->
                    <div class="flex justify-between items-center mb-4">
                        
                        <form action="{{ route('borrowings.index') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam atau buku..." class="border-gray-300 rounded-l-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-64">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-700 border border-transparent">Cari</button>
                            
                            @if(request('search'))
                                <a href="{{ route('borrowings.index') }}" class="ml-2 inline-flex items-center text-gray-500 hover:text-gray-700">Clear</a>
                            @endif
                        </form>

                        <a href="{{ route('borrowings.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            + Catat Peminjaman Baru
                        </a>

                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-2 text-sm text-gray-500">
                        Total <span class="font-bold text-gray-700">{{ $borrowings->total() }}</span> riwayat transaksi
                    </div>

                    <!-- Tabel Transaksi -->
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">Tgl Pinjam</th>
                                <th class="py-2 px-4 border-b text-left">Peminjam</th>
                                <th class="py-2 px-4 border-b text-left">Buku</th>
                                <th class="py-2 px-4 border-b text-left">Batas Kembali</th>
                                <th class="py-2 px-4 border-b text-center">Aksi / Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borrowings as $borrowing)
                                @php
                                    // Menghitung batas maksimal pengembalian (7 hari setelah tanggal pinjam)
                                    $dueDate = \Carbon\Carbon::parse($borrowing->borrow_date)->addDays(7);
                                    // Mengecek apakah hari ini sudah melewati batas waktu dan buku belum dikembalikan
                                    $isOverdue = !$borrowing->return_date && \Carbon\Carbon::today()->greaterThan($dueDate);
                                @endphp
                                
                                <tr class="{{ $isOverdue ? 'bg-red-50' : '' }}">
                                    <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d-m-Y') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $borrowing->member->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $borrowing->book->title }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if ($borrowing->return_date)
                                            <span class="text-sm text-green-600 font-semibold">
                                                Kembali: {{ \Carbon\Carbon::parse($borrowing->return_date)->format('d-m-Y') }}
                                            </span>
                                        @else
                                            <span class="text-sm {{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                                {{ $dueDate->format('d-m-Y') }}
                                            </span>
                                            @if($isOverdue)
                                                <br><span class="bg-red-200 text-red-800 text-xs font-semibold px-2 py-0.5 rounded">Overdue</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        @if (!$borrowing->return_date)
                                            <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST" class="inline-flex items-center">
                                                @csrf
                                                @method('PUT')
                                                <input type="date" name="return_date" class="border rounded py-1 px-2 mr-2 text-sm" required value="{{ date('Y-m-d') }}">
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-sm py-1 px-3 rounded" onclick="return confirm('Proses pengembalian buku ini?')">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-green-600 font-semibold">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $borrowings->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>