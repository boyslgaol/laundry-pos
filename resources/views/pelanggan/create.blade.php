@extends('layouts.app')
@section('title', 'Tambah Pelanggan')
@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pelanggan Baru</h2>
    
    <form method="POST" action="{{ route('pelanggan.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap *</label>
            <input type="text" name="nama" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
            <input type="text" name="telepon" class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">Simpan</button>
            <a href="{{ route('pelanggan.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">Batal</a>
        </div>
    </form>
</div>
@endsection