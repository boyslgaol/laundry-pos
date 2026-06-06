@extends('layouts.app')
@section('title', 'Edit Transaksi')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('transaksi.index') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Edit Transaksi</h2>
    </div>
    
    <form method="POST" action="{{ route('transaksi.update', $transaksi) }}" class="max-w-2xl mx-auto">
        @csrf
        @method('PUT')
        
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Kode Transaksi</label>
            <input type="text" value="{{ $transaksi->kode_transaksi }}" disabled class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2">
        </div>
        
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Pelanggan</label>
            <select name="pelanggan_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}" {{ $transaksi->pelanggan_id == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Layanan</label>
            <select name="layanan_id" id="layanan" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @foreach($layanans as $l)
                    <option value="{{ $l->id }}" data-harga="{{ $l->harga_per_kg }}" {{ $transaksi->layanan_id == $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Berat (Kg)</label>
            <input type="number" step="0.1" name="berat_kg" id="berat" value="{{ $transaksi->berat_kg }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>
        
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">Status</label>
            <select name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="diambil" {{ $transaksi->status == 'diambil' ? 'selected' : '' }}>Diambil</option>
            </select>
        </div>
        
        <div class="mb-6 bg-blue-50 p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <span class="font-semibold">Total Harga:</span>
                <span id="total" class="text-xl font-bold text-blue-600">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                Update Transaksi
            </button>
            <a href="{{ route('transaksi.index') }}" class="px-6 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-lg transition">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    const layanan = document.getElementById('layanan');
    const berat = document.getElementById('berat');
    const totalSpan = document.getElementById('total');
    
    function hitungTotal() {
        let selectedOption = layanan.options[layanan.selectedIndex];
        let harga = parseFloat(selectedOption.dataset.harga) || 0;
        let kg = parseFloat(berat.value) || 0;
        let total = harga * kg;
        totalSpan.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    layanan.addEventListener('change', hitungTotal);
    berat.addEventListener('input', hitungTotal);
</script>
@endsection