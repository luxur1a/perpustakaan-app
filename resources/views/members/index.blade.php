<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Header Aksi: Form Kiri, Tombol Kanan -->
                    <div class="flex justify-between items-center mb-4">
                        
                        <!-- Form Pencarian (Sekarang di Kiri) -->
                        <form action="{{ route('members.index') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anggota..." class="border-gray-300 rounded-l-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-700 border border-transparent">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('members.index') }}" class="ml-2 inline-flex items-center text-gray-500 hover:text-gray-700">Clear</a>
                            @endif
                        </form>

                        <!-- Tombol Tambah Anggota (Sekarang di Kanan) -->
                        <a href="{{ route('members.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            + Tambah Anggota
                        </a>

                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Info Jumlah Anggota -->
                    <div class="mb-2 text-sm text-gray-500">
                        Total <span class="font-bold text-gray-700">{{ $members->total() }}</span> anggota terdaftar
                    </div>

                    <!-- Tabel -->
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">No. Anggota</th>
                                <th class="py-2 px-4 border-b text-left">Nama</th>
                                <th class="py-2 px-4 border-b text-left">Tanggal Lahir</th>
                                <th class="py-2 px-4 border-b text-center">Buku Dipinjam</th>
                                <th class="py-2 px-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $member->member_no }}</td>
                                    <td class="py-2 px-4 border-b">{{ $member->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($member->date_of_birth)->format('d-m-Y') }}</td>
                                    <!-- Menampilkan Jumlah Pinjaman -->
                                    <td class="py-2 px-4 border-b text-center">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $member->borrowings_count }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <a href="{{ route('members.edit', $member->id) }}" class="text-yellow-500 hover:underline mr-2">Edit</a>
                                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Tombol Pagination -->
                    <div class="mt-4">
                        {{ $members->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>