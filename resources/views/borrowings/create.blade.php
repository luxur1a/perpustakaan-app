<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catat Peminjaman Baru') }}
        </h2>
    </x-slot>

    <!-- Memanggil CSS dari Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf

                        <!-- Dropdown Pencarian Anggota -->
                        <div class="mb-6">
                            <label for="member-select" class="block text-sm font-medium text-gray-700 mb-2">Pilih Anggota</label>
                            <select name="member_id" id="member-select" required placeholder="Ketik nama atau nomor anggota...">
                                <option value="">Pilih Anggota...</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->member_no }} - {{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dropdown Pencarian Buku -->
                        <div class="mb-6">
                            <label for="book-select" class="block text-sm font-medium text-gray-700 mb-2">Pilih Buku</label>
                            <select name="book_id" id="book-select" required placeholder="Ketik judul buku atau penerbit...">
                                <option value="">Pilih Buku...</option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} (Stok: {{ $book->stock }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Tanggal Pinjam -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pinjam</label>
                            <input type="date" name="borrow_date" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full" required value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('borrowings.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Batal</a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan Transaksi</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Memanggil Script JavaScript dari Tom Select -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    
    <!-- Menyalakan fitur Tom Select pada Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Search dropdown member
            new TomSelect("#member-select", {
                create: false, // User tidak boleh menambah nama baru dari form ini
                sortField: { field: "text", direction: "asc" } // Urutkan A-Z otomatis
            });

            // Search dropdown buku
            new TomSelect("#book-select", {
                create: false,
                sortField: { field: "text", direction: "asc" }
            });
        });
    </script>
</x-app-layout>