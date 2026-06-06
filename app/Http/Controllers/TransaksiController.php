<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
{
    $query = Transaksi::with(['pelanggan', 'layanan']);
    
    // Search
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('kode_transaksi', 'like', '%' . $request->search . '%')
              ->orWhereHas('pelanggan', function($q2) use ($request) {
                  $q2->where('nama', 'like', '%' . $request->search . '%');
              });
        });
    }
    
    // Filter by status
    if ($request->status) {
        $query->where('status', $request->status);
    }
    
    // Filter by date
    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }
    
    $transaksis = $query->latest()->paginate(15);
    return view('transaksi.index', compact('transaksis'));
}
    
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $layanans = Layanan::all();
        return view('transaksi.create', compact('pelanggans', 'layanans'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'layanan_id' => 'required|exists:layanans,id',
            'berat_kg' => 'required|numeric|min:0.5'
        ]);
        
        $layanan = Layanan::find($request->layanan_id);
        $total_harga = $layanan->harga_per_kg * $request->berat_kg;
        
        Transaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'layanan_id' => $request->layanan_id,
            'berat_kg' => $request->berat_kg,
            'total_harga' => $total_harga,
            'status' => 'pending'
        ]);
        
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
    }
    
    public function edit(Transaksi $transaksi)
    {
        $pelanggans = Pelanggan::all();
        $layanans = Layanan::all();
        return view('transaksi.edit', compact('transaksi', 'pelanggans', 'layanans'));
    }
    
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'layanan_id' => 'required|exists:layanans,id',
            'berat_kg' => 'required|numeric|min:0.5',
            'status' => 'required|in:pending,proses,selesai,diambil'
        ]);
        
        $layanan = Layanan::find($request->layanan_id);
        $total_harga = $layanan->harga_per_kg * $request->berat_kg;
        
        $transaksi->update([
            'pelanggan_id' => $request->pelanggan_id,
            'layanan_id' => $request->layanan_id,
            'berat_kg' => $request->berat_kg,
            'total_harga' => $total_harga,
            'status' => $request->status,
            'tanggal_ambil' => $request->status == 'diambil' ? Carbon::now() : $transaksi->tanggal_ambil
        ]);
        
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate');
    }
    
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
    
    public function cetakStruk(Transaksi $transaksi)
    {
        $transaksi->load(['pelanggan', 'layanan']);
        return view('transaksi.struk', compact('transaksi'));
    }
    
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,diambil'
        ]);
        
        $transaksi->update([
            'status' => $request->status,
            'tanggal_ambil' => $request->status == 'diambil' ? Carbon::now() : $transaksi->tanggal_ambil
        ]);
        
        return response()->json(['success' => true]);
    }
}