@extends('layouts.app')
@section('title', 'Edit Layanan')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('layanan.index') }}" class="text-gray-500 hover:text-gray-700 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-edit text-blue-600"></i>
            Edit Layanan
        </h2>
    </div>
    
    <form method="POST" action="{{ route('layanan.update', $layanan) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Informasi ID (Readonly) -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600">
                    <i class="fas fa-barcode mr-2"></i>ID Layanan:
                </span>
                <span class="font-mono font-semibold text-gray-800">#{{ $layanan->id }}</span>
            </div>
            <div class="flex justify-between items-center text-sm mt-2">
                <span class="text-gray-600">
                    <i class="fas fa-calendar-alt mr-2"></i>Dibuat pada:
                </span>
                <span class="text-gray-800">{{ $layanan->created_at->format('d/m/Y H:i') }}</span>
            </div>
            @if($layanan->updated_at != $layanan->created_at)
            <div class="flex justify-between items-center text-sm mt-2">
                <span class="text-gray-600">
                    <i class="fas fa-edit mr-2"></i>Terakhir diupdate:
                </span>
                <span class="text-gray-800">{{ $layanan->updated_at->format('d/m/Y H:i') }}</span>
            </div>
            @endif
        </div>
        
        <!-- Nama Layanan -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-tag text-blue-600 mr-2"></i>
                Nama Layanan <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nama" 
                   value="{{ old('nama', $layanan->nama) }}"
                   required 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('nama') border-red-500 @enderror"
                   placeholder="Contoh: Cuci Kering Reguler">
            @error('nama')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Harga per KG -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-money-bill-wave text-blue-600 mr-2"></i>
                Harga per Kilogram (Rp) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                <input type="number" 
                       name="harga_per_kg" 
                       value="{{ old('harga_per_kg', $layanan->harga_per_kg) }}"
                       required 
                       step="500"
                       min="0"
                       class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('harga_per_kg') border-red-500 @enderror"
                       placeholder="0">
            </div>
            @error('harga_per_kg')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Preview Harga (Live) -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
            <div class="flex justify-between items-center">
                <span class="text-gray-700 font-medium">
                    <i class="fas fa-calculator text-blue-600 mr-2"></i>
                    Preview Harga:
                </span>
                <span id="previewHarga" class="text-xl font-bold text-blue-600">Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}</span>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-3 text-sm">
                <div class="flex justify-between items-center p-2 bg-white rounded">
                    <span class="text-gray-600">1 kg:</span>
                    <span id="preview1kg" class="font-semibold text-gray-800">Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white rounded">
                    <span class="text-gray-600">2 kg:</span>
                    <span id="preview2kg" class="font-semibold text-gray-800">Rp {{ number_format($layanan->harga_per_kg * 2, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white rounded">
                    <span class="text-gray-600">3 kg:</span>
                    <span id="preview3kg" class="font-semibold text-gray-800">Rp {{ number_format($layanan->harga_per_kg * 3, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-2 bg-white rounded">
                    <span class="text-gray-600">5 kg:</span>
                    <span id="preview5kg" class="font-semibold text-gray-800">Rp {{ number_format($layanan->harga_per_kg * 5, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="mt-2 text-center text-xs text-gray-500">
                * Harga akan berubah saat Anda mengedit
            </div>
        </div>
        
        <!-- Informasi Total Transaksi Terkait -->
        @if($layanan->transaksis()->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-yellow-600 mr-2 mt-0.5"></i>
                <div class="text-sm text-yellow-700">
                    <strong>Informasi:</strong> Layanan ini telah digunakan pada 
                    <strong>{{ $layanan->transaksis()->count() }}</strong> transaksi.
                    Mengubah harga akan mempengaruhi laporan pendapatan di masa mendatang.
                </div>
            </div>
        </div>
        @endif
        
        <!-- Tombol Aksi -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                Update Layanan
            </button>
            <a href="{{ route('layanan.index') }}" class="px-6 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-times"></i>
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const hargaInput = document.querySelector('input[name="harga_per_kg"]');
    const preview1kg = document.getElementById('preview1kg');
    const preview2kg = document.getElementById('preview2kg');
    const preview3kg = document.getElementById('preview3kg');
    const preview5kg = document.getElementById('preview5kg');
    const previewHarga = document.getElementById('previewHarga');
    
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }
    
    function updatePreview() {
        let harga = parseFloat(hargaInput.value) || 0;
        previewHarga.textContent = formatRupiah(harga);
        preview1kg.textContent = formatRupiah(harga);
        preview2kg.textContent = formatRupiah(harga * 2);
        preview3kg.textContent = formatRupiah(harga * 3);
        preview5kg.textContent = formatRupiah(harga * 5);
    }
    
    hargaInput.addEventListener('input', updatePreview);
</script>
@endpush
@endsection