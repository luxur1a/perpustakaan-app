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
                    
                    <!-- Header Aksi -->
                    <div class="flex justify-between items-center mb-4">
                        
                        <!-- Form Pencarian -->
                        <form action="{{ route('books.index') }}" method="GET" class="flex">
                            @if(request('sort_by'))
                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                <input type="hidden" name="order" value="{{ request('order') }}">
                            @endif
                            
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau penerbit..." class="border-gray-300 rounded-l-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-64">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-700 border border-transparent">Cari</button>
                            
                            <!-- Tombol Clear -->
                            @if(request('search'))
                                <a href="{{ route('books.index', ['sort_by' => request('sort_by'), 'order' => request('order')]) }}" class="ml-2 inline-flex items-center text-gray-500 hover:text-gray-700">Clear</a>
                            @endif
                        </form>

                        <!-- Tombol Tambah Buku ( -->
                        <a href="{{ route('books.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            + Tambah Buku
                        </a>

                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Info Jumlah Buku -->
                    <div class="mb-2 text-sm text-gray-500">
                        Total <span class="font-bold text-gray-700">{{ $books->total() }}</span> judul buku terdaftar
                    </div>

                    <!-- Tabel Data Buku -->
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <!-- Header Judul Buku dengan Sorting -->
                                <th class="py-2 px-4 border-b text-left">
                                    <a href="{{ route('books.index', ['sort_by' => 'title', 'order' => ($sortBy == 'title' && $order == 'asc') ? 'desc' : 'asc']) }}" 
                                       class="flex items-center text-gray-700 hover:text-blue-500">
                                        Judul Buku
                                        @if($sortBy == 'title')
                                            <span class="ml-1 text-xs">{{ $order == 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                
                                <!-- Header Penerbit dengan Sorting -->
                                <th class="py-2 px-4 border-b text-left">
                                    <a href="{{ route('books.index', ['sort_by' => 'publisher', 'order' => ($sortBy == 'publisher' && $order == 'asc') ? 'desc' : 'asc']) }}" 
                                       class="flex items-center text-gray-700 hover:text-blue-500">
                                        Penerbit
                                        @if($sortBy == 'publisher')
                                            <span class="ml-1 text-xs">{{ $order == 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                
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
                                    <td class="py-2 px-4 border-b text-center">
                                        <span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded border border-gray-400">
                                            {{ $book->stock }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <a href="{{ route('books.edit', $book->id) }}" class="text-yellow-500 hover:underline mr-2">Edit</a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tombol Navigasi Pagination -->
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>