@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('transaksi.index') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800">Transaksi Baru</h2>
    </div>
    
    <form method="POST" action="{{ route('transaksi.store') }}" class="max-w-2xl mx-auto">
        @csrf
        
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-user mr-2 text-blue-600"></i>Pelanggan
            </label>
            <select name="pelanggan_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Pilih Pelanggan</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->telepon ?? '-' }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-tag mr-2 text-blue-600"></i>Layanan
            </label>
            <select name="layanan_id" id="layanan" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Pilih Layanan</option>
                @foreach($layanans as $l)
                    <option value="{{ $l->id }}" data-harga="{{ $l->harga_per_kg }}">{{ $l->nama }} - Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}/kg</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-5">
            <label class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-weight-hanging mr-2 text-blue-600"></i>Berat (Kg)
            </label>
            <input type="number" step="0.1" name="berat_kg" id="berat" required 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Contoh: 2.5">
        </div>
        
        <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
            <div class="flex justify-between items-center">
                <span class="text-gray-700 font-semibold">
                    <i class="fas fa-calculator mr-2 text-blue-600"></i>Total yang harus dibayar:
                </span>
                <span id="total" class="text-2xl font-bold text-blue-600">Rp 0</span>
            </div>
        </div>
        
        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                Simpan Transaksi
            </button>
            <a href="{{ route('transaksi.index') }}" class="px-6 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-lg transition flex items-center">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const layanan = document.getElementById('layanan');
    const berat = document.getElementById('berat');
    const totalSpan = document.getElementById('total');
    
    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }
    
    function hitungTotal() {
        let selectedOption = layanan.options[layanan.selectedIndex];
        let harga = selectedOption && selectedOption.dataset.harga ? parseFloat(selectedOption.dataset.harga) : 0;
        let kg = parseFloat(berat.value) || 0;
        let total = harga * kg;
        totalSpan.innerText = formatRupiah(total);
    }
    
    layanan.addEventListener('change', hitungTotal);
    berat.addEventListener('input', hitungTotal);
</script>
@endpush
@endsection