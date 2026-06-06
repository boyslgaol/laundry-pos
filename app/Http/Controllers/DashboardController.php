<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Hari Ini
        $today = Carbon::today();
        $transaksiHariIni = Transaksi::whereDate('created_at', $today)->count();
        $pendapatanHariIni = Transaksi::whereDate('created_at', $today)->sum('total_harga');
        $beratHariIni = Transaksi::whereDate('created_at', $today)->sum('berat_kg');
        
        // Statistik Bulan Ini
        $thisMonth = Carbon::now()->startOfMonth();
        $pendapatanBulanIni = Transaksi::whereMonth('created_at', Carbon::now()->month)->sum('total_harga');
        $transaksiBulanIni = Transaksi::whereMonth('created_at', Carbon::now()->month)->count();
        
        // Statistik Minggu Ini
        $thisWeek = Carbon::now()->startOfWeek();
        $pendapatanMingguIni = Transaksi::whereBetween('created_at', [$thisWeek, Carbon::now()])->sum('total_harga');
        
        // Grafik 7 Hari Terakhir
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartData['labels'][] = $date->format('d/m');
            $chartData['pendapatan'][] = Transaksi::whereDate('created_at', $date)->sum('total_harga');
            $chartData['transaksi'][] = Transaksi::whereDate('created_at', $date)->count();
        }
        
        // Top Pelanggan
        $topPelanggan = Transaksi::selectRaw('pelanggan_id, SUM(total_harga) as total')
            ->with('pelanggan')
            ->groupBy('pelanggan_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Status Transaksi
        $statusCount = [
            'pending' => Transaksi::where('status', 'pending')->count(),
            'proses' => Transaksi::where('status', 'proses')->count(),
            'selesai' => Transaksi::where('status', 'selesai')->count(),
            'diambil' => Transaksi::where('status', 'diambil')->count(),
        ];
        
        // Layanan Terlaris
        $topLayanan = Transaksi::selectRaw('layanan_id, COUNT(*) as total_transaksi, SUM(total_harga) as total_pendapatan')
            ->with('layanan')
            ->groupBy('layanan_id')
            ->orderBy('total_transaksi', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'transaksiHariIni', 'pendapatanHariIni', 'beratHariIni',
            'pendapatanBulanIni', 'transaksiBulanIni', 'pendapatanMingguIni',
            'chartData', 'topPelanggan', 'statusCount', 'topLayanan'
        ));
    }
}