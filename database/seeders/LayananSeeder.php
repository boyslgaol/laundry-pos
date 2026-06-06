<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            ['nama' => 'Cuci Kering Reguler', 'harga_per_kg' => 6000],
            ['nama' => 'Cuci Kering Express', 'harga_per_kg' => 10000],
            ['nama' => 'Setrika Saja', 'harga_per_kg' => 4000],
            ['nama' => 'Cuci + Setrika', 'harga_per_kg' => 8000],
            ['nama' => 'Dry Cleaning', 'harga_per_kg' => 15000],
            ['nama' => 'Bed Cover (per pcs)', 'harga_per_kg' => 20000],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}