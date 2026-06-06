@extends('layouts.app')
@section('title', 'Tambah Layanan')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('layanan.index') }}" class="text-gray-500 hover:text-gray-700 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-plus-circle text-blue-600"></i>
            Tambah Layanan Baru
        </h2>
    </div>
    
    <form method="POST" action="{{ route('layanan.store') }}" class="space-y-6">
        @csrf
        
        <!-- Nama Layanan -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">
                <i class="fas fa-tag text-blue-600 mr-2"></i>
                Nama Layanan <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nama" 
                   value="{{ old('nama') }}"
                   required 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('nama') border-red-500 @enderror"
                   placeholder="Contoh: Cuci Kering Reguler">
            @error('nama')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-400 text-xs mt-1">Masukkan nama layanan yang akan ditawarkan</p>
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
                       value="{{ old('harga_per_kg') }}"
                       required 
                       step="500"
                       min="0"
                       class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('harga_per_kg') border-red-500 @enderror"
                       placeholder="0">
            </div>
            @error('harga_per_kg')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-400 text-xs mt-1">Harga dalam Rupiah per kilogram (contoh: 6000)</p>
        </div>
        
        <!-- Preview Harga (Live) -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
            <div class="flex justify-between items-center">
                <span class="text-gray-700 font-medium">
                    <i class="fas fa-calculator text-blue-600 mr-2"></i>
                    Preview Harga untuk 1 kg:
                </span>
                <span id="previewHarga" class="text-xl font-bold text-blue-600">Rp 0</span>
            </div>
            <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                <span>2 kg:</span>
                <span id="preview2kg">Rp 0</span>
                <span>5 kg:</span>
                <span id="preview5kg">Rp 0</span>
                <span>10 kg:</span>
                <span id="preview10kg">Rp 0</span>
            </div>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                Simpan Layanan
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
    const previewHarga = document.getElementById('previewHarga');
    const preview2kg = document.getElementById('preview2kg');
    const preview5kg = document.getElementById('preview5kg');
    const preview10kg = document.getElementById('preview10kg');
    
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }
    
    function updatePreview() {
        let harga = parseFloat(hargaInput.value) || 0;
        previewHarga.textContent = formatRupiah(harga);
        preview2kg.textContent = formatRupiah(harga * 2);
        preview5kg.textContent = formatRupiah(harga * 5);
        preview10kg.textContent = formatRupiah(harga * 10);
    }
    
    hargaInput.addEventListener('input', updatePreview);
    updatePreview(); // Initial preview
</script>
@endpush
@endsection