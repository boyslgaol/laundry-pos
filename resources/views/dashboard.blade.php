@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->check() ? auth()->user()->name : 'Admin' }}! 👋</h1>
                <p class="text-blue-100">{{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold">Laundry POS</div>
                <div class="text-blue-100">Sistem Kasir Profesional</div>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $transaksiHariIni }} transaksi | {{ number_format($beratHariIni, 1) }} kg</p>
                </div>
                <i class="fas fa-money-bill-wave text-3xl text-blue-600"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-600 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Pendapatan Minggu Ini</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($pendapatanMingguIni, 0, ',', '.') }}</p>
                </div>
                <i class="fas fa-calendar-week text-3xl text-green-600"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-purple-600 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Pendapatan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $transaksiBulanIni }} transaksi</p>
                </div>
                <i class="fas fa-calendar-alt text-3xl text-purple-600"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-orange-600 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Status Proses</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $statusCount['proses'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Pending: {{ $statusCount['pending'] }}</p>
                </div>
                <i class="fas fa-spinner fa-pulse text-3xl text-orange-600"></i>
            </div>
        </div>
    </div>
    
    <!-- Charts & Top Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                Grafik Pendapatan 7 Hari Terakhir
            </h3>
            <canvas id="revenueChart" height="250"></canvas>
        </div>
        
        <!-- Top Pelanggan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                Top 5 Pelanggan Terbanyak
            </h3>
            <div class="space-y-3">
                @foreach($topPelanggan as $pelanggan)
                <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                    <div>
                        <div class="font-medium text-gray-800">{{ $pelanggan->pelanggan->nama }}</div>
                        <div class="text-xs text-gray-400">{{ $pelanggan->pelanggan->telepon ?? '-' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-blue-600">Rp {{ number_format($pelanggan->total, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Layanan Terlaris -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-green-600 mr-2"></i>
                Layanan Terlaris
            </h3>
            @foreach($topLayanan as $layanan)
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1">
                    <span>{{ $layanan->layanan->nama }}</span>
                    <span class="font-semibold">{{ $layanan->total_transaksi }} transaksi</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 rounded-full h-2" style="width: {{ ($layanan->total_transaksi / max($topLayanan->first()->total_transaksi, 1)) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                Aksi Cepat
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('transaksi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg text-center transition">
                    <i class="fas fa-plus-circle text-xl mb-1 block"></i>
                    Transaksi Baru
                </a>
                <a href="{{ route('laporan.index') }}" class="bg-green-600 hover:bg-green-700 text-white p-3 rounded-lg text-center transition">
                    <i class="fas fa-chart-line text-xl mb-1 block"></i>
                    Lihat Laporan
                </a>
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white p-3 rounded-lg text-center transition">
                    <i class="fas fa-print text-xl mb-1 block"></i>
                    Cetak Laporan
                </button>
                <button onclick="exportData()" class="bg-purple-600 hover:bg-purple-700 text-white p-3 rounded-lg text-center transition">
                    <i class="fas fa-download text-xl mb-1 block"></i>
                    Export Data
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData['pendapatan']) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { callbacks: { label: (ctx) => `Rp ${ctx.raw.toLocaleString('id-ID')}` } }
            },
            scales: { y: { beginAtZero: true, ticks: { callback: (value) => `Rp ${value/1000}k` } } }
        }
    });
    
    function exportData() {
        Swal.fire({
            title: 'Export Data',
            text: 'Pilih format export:',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Excel',
            cancelButtonText: 'PDF',
            showDenyButton: true,
            denyButtonText: 'CSV'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = "{{ route('laporan.export') }}?format=excel";
            else if (result.isDenied) window.location.href = "{{ route('laporan.export') }}?format=csv";
            else if (result.dismiss === Swal.DismissReason.cancel) window.location.href = "{{ route('laporan.export') }}?format=pdf";
        });
    }
</script>
@endpush
@endsection