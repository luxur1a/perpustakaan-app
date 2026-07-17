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
                    
                    <a href="{{ route('borrowings.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">
                        + Catat Peminjaman Baru
                    </a>

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

                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">Tgl Pinjam</th>
                                <th class="py-2 px-4 border-b text-left">Peminjam</th>
                                <th class="py-2 px-4 border-b text-left">Buku</th>
                                <th class="py-2 px-4 border-b text-left">Tgl Kembali</th>
                                <th class="py-2 px-4 border-b text-center">Aksi / Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borrowings as $borrowing)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d-m-Y') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $borrowing->member->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $borrowing->book->title }}</td>
                                    <td class="py-2 px-4 border-b">
                                        {{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->format('d-m-Y') : 'Belum Dikembalikan' }}
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <!-- Jika buku belum dikembalikan, tampilkan tombol form pengembalian -->
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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>