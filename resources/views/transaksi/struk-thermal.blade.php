<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Laundry</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Courier New', monospace;
            width: 280px;
            margin: 0 auto;
            padding: 10px;
            background: white;
            font-size: 12px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .border-bottom { border-bottom: 1px dashed #000; margin: 8px 0; }
        .border-top { border-top: 1px dashed #000; margin: 8px 0; }
        .header { margin-bottom: 10px; }
        .store-name { font-size: 18px; font-weight: bold; color: #2563eb; }
        .info-row { display: flex; justify-content: space-between; margin: 4px 0; }
        .total { font-size: 16px; margin-top: 8px; padding-top: 8px; border-top: 1px solid #000; }
        .footer { text-align: center; margin-top: 10px; font-size: 10px; }
        .qr-code { text-align: center; margin: 10px 0; }
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header text-center">
        <div class="store-name">🧺 LAUNDRY POS</div>
        <div>Jl. Contoh No. 123, Kota</div>
        <div>Telp: 0812-3456-7890</div>
        <div>{{ now()->format('d/m/Y H:i:s') }}</div>
    </div>
    
    <div class="border-bottom"></div>
    
    <div class="info-row">
        <span>Kode Transaksi</span>
        <span class="text-bold">{{ $transaksi->kode_transaksi }}</span>
    </div>
    <div class="info-row">
        <span>Kasir</span>
        <span>{{ auth()->check() ? auth()->user()->name : 'Admin' }}</span>
    </div>
    <div class="info-row">
        <span>Pelanggan</span>
        <span>{{ $transaksi->pelanggan->nama }}</span>
    </div>
    
    <div class="border-bottom"></div>
    
    <div class="info-row">
        <span>{{ $transaksi->layanan->nama }}</span>
        <span>{{ number_format($transaksi->berat_kg, 1) }} kg</span>
    </div>
    <div class="info-row">
        <span>Harga/kg</span>
        <span>Rp {{ number_format($transaksi->layanan->harga_per_kg, 0, ',', '.') }}</span>
    </div>
    
    <div class="border-bottom"></div>
    
    <div class="total info-row">
        <span class="text-bold">TOTAL</span>
        <span class="text-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
    </div>
    
    <div class="info-row">
        <span>Status</span>
        <span class="text-bold">{{ strtoupper($transaksi->status) }}</span>
    </div>
    
    @if($transaksi->tanggal_ambil)
    <div class="info-row">
        <span>Diambil</span>
        <span>{{ $transaksi->tanggal_ambil->format('d/m/Y') }}</span>
    </div>
    @endif
    
    <div class="border-top"></div>
    
    <div class="footer">
        <div>Terima kasih atas kepercayaan Anda</div>
        <div>Simpan struk ini sebagai bukti</div>
        <div class="qr-code no-print">
            <button onclick="window.print()" style="padding: 5px 10px; margin-top: 10px;">🖨️ Cetak Struk</button>
        </div>
    </div>
    
    <script>
        // Auto print
        window.onload = function() {
            setTimeout(() => {
                window.print();
                setTimeout(() => window.close(), 500);
            }, 500);
        }
    </script>
</body>
</html>