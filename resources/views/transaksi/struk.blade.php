<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Laundry</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h2 {
            color: #2563eb;
            margin-bottom: 5px;
        }
        .info {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #000;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
        .status {
            text-align: center;
            margin-top: 10px;
            padding: 5px;
            background: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>🧺 Laundry POS</h2>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="info">
        <div><strong>Kode:</strong> {{ $transaksi->kode_transaksi }}</div>
        <div><strong>Pelanggan:</strong> {{ $transaksi->pelanggan->nama }}</div>
        <div><strong>Telepon:</strong> {{ $transaksi->pelanggan->telepon ?? '-' }}</div>
    </div>
    
    <div class="divider"></div>
    
    <div class="info">
        <div><strong>Layanan:</strong> {{ $transaksi->layanan->nama }}</div>
        <div><strong>Berat:</strong> {{ number_format($transaksi->berat_kg, 1) }} kg</div>
        <div><strong>Harga/kg:</strong> Rp {{ number_format($transaksi->layanan->harga_per_kg, 0, ',', '.') }}</div>
    </div>
    
    <div class="divider"></div>
    
    <div class="total">
        TOTAL: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
    </div>
    
    <div class="status">
        STATUS: {{ strtoupper($transaksi->status) }}
    </div>
    
    @if($transaksi->tanggal_ambil)
    <div style="text-align: center; margin-top: 10px;">
        Diambil: {{ $transaksi->tanggal_ambil->format('d/m/Y') }}
    </div>
    @endif
    
    <div class="footer">
        Terima kasih atas kepercayaan Anda<br>
        Simpan struk ini sebagai bukti
    </div>
    
    <script>
        window.print();
        setTimeout(() => window.close(), 1000);
    </script>
</body>
</html>