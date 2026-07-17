<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('books.update', $book->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Buku</label>
                            <input type="text" name="title" class="border rounded w-full py-2 px-3" value="{{ old('title', $book->title) }}" required>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Penerbit</label>
                            <input type="text" name="publisher" class="border rounded w-full py-2 px-3" value="{{ old('publisher', $book->publisher) }}" required>
                            @error('publisher') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Dimensi (Contoh: 14x21 cm)</label>
                            <input type="text" name="dimension" class="border rounded w-full py-2 px-3" value="{{ old('dimension', $book->dimension) }}" required>
                            @error('dimension') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stok Tersedia</label>
                            <input type="number" name="stock" class="border rounded w-full py-2 px-3" value="{{ old('stock', $book->stock) }}" min="0" required>
                            @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Data
                            </button>
                            <a href="{{ route('books.index') }}" class="text-gray-500 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>