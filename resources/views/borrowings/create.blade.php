<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Peminjaman Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Anggota Peminjam</label>
                            <select name="member_id" class="border rounded w-full py-2 px-3" required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->member_no }} - {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Buku yang Dipinjam</label>
                            <select name="book_id" class="border rounded w-full py-2 px-3" required>
                                <option value="">-- Pilih Buku --</option>
                                @foreach($books as $book)
                                    <!-- Hanya menampilkan buku yang stoknya ada (diatur di Controller) -->
                                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                        {{ $book->title }} (Stok Tersedia: {{ $book->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('book_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pinjam</label>
                            <!-- Otomatis terisi tanggal hari ini, tapi bisa diganti -->
                            <input type="date" name="borrow_date" class="border rounded w-full py-2 px-3" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                            @error('borrow_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Proses Peminjaman
                            </button>
                            <a href="{{ route('borrowings.index') }}" class="text-gray-500 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>