<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::latest()->paginate(10);
        return view('layanan.index', compact('layanans'));
    }
    
    public function create()
    {
        return view('layanan.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0'
        ]);
        
        Layanan::create($request->all());
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan');
    }
    
    public function edit(Layanan $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }
    
    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0'
        ]);
        
        $layanan->update($request->all());
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diupdate');
    }
    
    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus');
    }
}