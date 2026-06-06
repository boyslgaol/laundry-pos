@extends('layouts.app')
@section('title', 'Data Layanan')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-tags text-blue-600 mr-2"></i>Data Layanan
        </h2>
        <a href="{{ route('layanan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Tambah Layanan
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2">
                <tr><th class="p-3">No</th><th class="p-3">Nama Layanan</th><th class="p-3 text-right">Harga/Kg</th><th class="text-center p-3">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($layanans as $index => $l)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3 font-medium">{{ $l->nama }}</td>
                    <td class="p-3 text-right font-semibold text-blue-600">Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('layanan.edit', $l) }}" class="text-blue-600 mx-1"><i class="fas fa-edit"></i></a>
                        <form id="delete-{{ $l->id }}" action="{{ route('layanan.destroy', $l) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-{{ $l->id }}')" class="text-red-600 mx-1"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $layanans->links() }}
</div>
@endsection