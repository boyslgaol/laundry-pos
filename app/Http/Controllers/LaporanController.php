<?php

namespace App\Http\Controllers;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
        $format = $request->format ?? 'excel';   
        $export = new LaporanExport($startDate, $endDate);

        if ($format === 'excel') {
        return Excel::download($export, 'laporan-laundry.xlsx');
        } elseif ($format === 'csv') {
            return Excel::download($export, 'laporan-laundry.csv', \Maatwebsite\Excel\Excel::CSV);
        } elseif ($format === 'pdf') {
            $transaksis = Transaksi::with(['pelanggan', 'layanan'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
        $pdf = Pdf::loadView('laporan.pdf', compact('transaksis', 'startDate', 'endDate'));
        return $pdf->download('laporan-laundry.pdf');
    
        
        $totalPendapatan = $transaksis->sum('total_harga');
        $totalTransaksi = $transaksis->count();
        $totalBerat = $transaksis->sum('berat_kg');
        
        $statistikPerLayanan = $transaksis->groupBy('layanan.nama')->map(function ($item) {
            return [
                'jumlah' => $item->count(),
                'total' => $item->sum('total_harga')
            ];
        });
        
        return view('laporan.index', compact(
            'transaksis', 
            'totalPendapatan', 
            'totalTransaksi', 
            'totalBerat',
            'statistikPerLayanan',
            'startDate',
            'endDate'
        ));
    }
    }
}
