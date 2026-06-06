@extends('layouts.app')
@section('title', 'Daftar Transaksi')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Cari Kode/Pelanggan</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg"
                       placeholder="Kode atau nama pelanggan...">
            </div>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>Diambil</option>
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>
    </form>
    <div class="flex justify-between mt-4">
        <button onclick="document.getElementById('filterForm').submit()" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-filter mr-2"></i>Filter
        </button>
        <a href="{{ route('transaksi.index') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-undo mr-1"></i>Reset Filter
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-receipt text-blue-600"></i>
            Daftar Transaksi
        </h2>
        <a href="{{ route('transaksi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Transaksi Baru
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="text-left p-3 text-gray-600">Kode</th>
                    <th class="text-left p-3 text-gray-600">Tanggal</th>
                    <th class="text-left p-3 text-gray-600">Pelanggan</th>
                    <th class="text-left p-3 text-gray-600">Layanan</th>
                    <th class="text-right p-3 text-gray-600">Berat</th>
                    <th class="text-right p-3 text-gray-600">Total</th>
                    <th class="text-center p-3 text-gray-600">Status</th>
                    <th class="text-center p-3 text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="p-3 font-mono text-sm">{{ $t->kode_transaksi }}</td>
                    <td class="p-3 text-sm">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ $t->pelanggan->nama }}</td>
                    <td class="p-3">{{ $t->layanan->nama }}</td>
                    <td class="p-3 text-right">{{ number_format($t->berat_kg, 1) }} kg</td>
                    <td class="p-3 text-right font-semibold text-blue-600">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td class="p-3 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($t->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($t->status == 'proses') bg-blue-100 text-blue-800
                            @elseif($t->status == 'selesai') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($t->status) }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('transaksi.edit', $t) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('transaksi.cetak', $t) }}" target="_blank" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-print"></i>
                            </a>
                            <form id="delete-form-{{ $t->id }}" action="{{ route('transaksi.destroy', $t) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('delete-form-{{ $t->id }}')" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center p-8 text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-2 block"></i>
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $transaksis->links() }}
    </div>
</div>
@endsection