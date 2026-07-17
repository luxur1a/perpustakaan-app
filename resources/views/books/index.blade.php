<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a href="{{ route('books.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">
                        + Tambah Buku
                    </a>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">Judul Buku</th>
                                <th class="py-2 px-4 border-b text-left">Penerbit</th>
                                <th class="py-2 px-4 border-b text-left">Dimensi</th>
                                <th class="py-2 px-4 border-b text-center">Stok</th>
                                <th class="py-2 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                                    <td class="py-2 px-4 border-b">{{ $book->publisher }}</td>
                                    <td class="py-2 px-4 border-b">{{ $book->dimension }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $book->stock }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <a href="{{ route('books.edit', $book->id) }}" class="text-yellow-500 hover:underline mr-2">Edit</a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus data buku ini?')">Hapus</button>
                                        </form>
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