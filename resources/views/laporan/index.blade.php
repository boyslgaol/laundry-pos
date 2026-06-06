@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-filter text-blue-600 mr-2"></i>Filter Laporan</h3>
        <form method="GET" class="flex gap-4 flex-wrap">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="border rounded-lg px-3 py-2">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Tampilkan</button>
            </div>
        </form>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-5">
            <div class="text-gray-500 text-sm">Total Pendapatan</div>
            <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-600 p-5">
            <div class="text-gray-500 text-sm">Jumlah Transaksi</div>
            <div class="text-2xl font-bold text-green-600">{{ $totalTransaksi }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-purple-600 p-5">
            <div class="text-gray-500 text-sm">Total Berat</div>
            <div class="text-2xl font-bold text-purple-600">{{ number_format($totalBerat, 1) }} kg</div>
        </div>
    </div>
    
    <!-- Statistik per Layanan -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-chart-pie text-blue-600 mr-2"></i>Statistik per Layanan</h3>
        <div class="space-y-3">
            @foreach($statistikPerLayanan as $nama => $data)
            <div class="flex justify-between items-center border-b py-2">
                <div>
                    <span class="font-medium">{{ $nama }}</span>
                    <span class="text-sm text-gray-500 ml-2">({{ $data['jumlah'] }} transaksi)</span>
                </div>
                <div class="font-semibold text-blue-600">Rp {{ number_format($data['total'], 0, ',', '.') }}</div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Daftar Transaksi -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4">Detail Transaksi</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr><th class="p-2">Tanggal</th><th>Kode</th><th>Pelanggan</th><th>Layanan</th><th class="text-right">Berat</th><th class="text-right">Total</th></tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $t)
                    <tr class="border-b">
                        <td class="p-2">{{ $t->created_at->format('d/m/Y') }}</td>
                        <td class="p-2 font-mono">{{ $t->kode_transaksi }}</td>
                        <td class="p-2">{{ $t->pelanggan->nama }}</td>
                        <td class="p-2">{{ $t->layanan->nama }}</td>
                        <td class="p-2 text-right">{{ $t->berat_kg }} kg</td>
                        <td class="p-2 text-right font-semibold">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection