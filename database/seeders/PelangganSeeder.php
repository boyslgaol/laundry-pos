<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggans = [
            ['nama' => 'Budi Santoso', 'telepon' => '081234567890', 'alamat' => 'Jl. Merdeka No. 123, Jakarta'],
            ['nama' => 'Siti Aminah', 'telepon' => '081298765432', 'alamat' => 'Jl. Sudirman No. 45, Bandung'],
            ['nama' => 'Agus Wijaya', 'telepon' => '081355566677', 'alamat' => 'Jl. Diponegoro No. 78, Surabaya'],
            ['nama' => 'Dewi Kartika', 'telepon' => '081377788899', 'alamat' => 'Jl. Gatot Subroto No. 90, Medan'],
            ['nama' => 'Rudi Hartono', 'telepon' => '081344455566', 'alamat' => 'Jl. Thamrin No. 12, Semarang'],
        ];

        foreach ($pelanggans as $pelanggan) {
            Pelanggan::create($pelanggan);
        }
    }
}