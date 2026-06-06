@extends('layouts.app')
@section('title', 'Data Pelanggan')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-users text-blue-600 mr-2"></i>Data Pelanggan
        </h2>
        <a href="{{ route('pelanggan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>Tambah Pelanggan
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2">
                <tr>
                    <th class="text-left p-3">No</th>
                    <th class="text-left p-3">Nama</th>
                    <th class="text-left p-3">Telepon</th>
                    <th class="text-left p-3">Alamat</th>
                    <th class="text-center p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggans as $index => $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3 font-medium">{{ $p->nama }}</td>
                    <td class="p-3">{{ $p->telepon ?? '-' }}</td>
                    <td class="p-3">{{ Str::limit($p->alamat, 30) ?? '-' }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('pelanggan.edit', $p) }}" class="text-blue-600 hover:text-blue-800 mx-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="delete-{{ $p->id }}" action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-{{ $p->id }}')" class="text-red-600 hover:text-red-800 mx-1">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $pelanggans->links() }}
</div>
@endsection