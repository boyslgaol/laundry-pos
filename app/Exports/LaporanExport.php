<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    
    public function collection()
    {
        return Transaksi::with(['pelanggan', 'layanan'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'Tanggal',
            'Pelanggan',
            'Telepon',
            'Layanan',
            'Berat (Kg)',
            'Harga/Kg',
            'Total Harga',
            'Status',
            'Tanggal Ambil'
        ];
    }
    
    public function map($transaksi): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        return [
            $rowNumber,
            $transaksi->kode_transaksi,
            $transaksi->created_at->format('d/m/Y H:i'),
            $transaksi->pelanggan->nama,
            $transaksi->pelanggan->telepon ?? '-',
            $transaksi->layanan->nama,
            $transaksi->berat_kg,
            $transaksi->layanan->harga_per_kg,
            $transaksi->total_harga,
            $transaksi->status,
            $transaksi->tanggal_ambil ? $transaksi->tanggal_ambil->format('d/m/Y') : '-',
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:K1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2563eb']]],
        ];
    }
}