<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriSampah;
use App\Models\SaldoPelanggan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Pelanggan',
        //     'email' => 'pelanggan@gmail.com',
        //     'password' => Hash::make('pelanggan123'),
        //     'role' => 'pelanggan',
        // ]);

        //    User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin123'),
        //     'role' => 'admin',
        // ]);

        // User::create([
        //     'name' => 'Petugas',
        //     'email' => 'petugas@gmail.com',
        //     'password' => Hash::make('petugas123'),
        //     'role' => 'petugas',
        // ]);

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@banksampah.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Bank Sampah No. 1',
            'status' => 'aktif',
        ]);

        $petugas1 = User::create([
            'name' => 'Petugas 1',
            'email' => 'petugas1@banksampah.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'phone' => '081234567891',
            'address' => 'Jl. Bank Sampah No. 2',
            'status' => 'aktif',
        ]);

        $petugas2 = User::create([
            'name' => 'Petugas 2',
            'email' => 'petugas2@banksampah.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'phone' => '081234567892',
            'address' => 'Jl. Bank Sampah No. 3',
            'status' => 'aktif',
        ]);

        $pelanggan1 = User::create([
            'name' => 'Pelanggan 1',
            'email' => 'pelanggan1@example.com',
            'password' => Hash::make('pelanggan123'),
            'role' => 'pelanggan',
            'phone' => '081234567893',
            'address' => 'Jl. Pelanggan No. 1',
            'status' => 'aktif',
        ]);

        $pelanggan2 = User::create([
            'name' => 'Pelanggan 2',
            'email' => 'pelanggan2@example.com',
            'password' => Hash::make('pelanggan123'),
            'role' => 'pelanggan',
            'phone' => '081234567894',
            'address' => 'Jl. Pelanggan No. 2',
            'status' => 'aktif',
        ]);

        // Seed Saldo Pelanggan (otomatis untuk setiap pelanggan)
        SaldoPelanggan::create([
            'user_id' => $pelanggan1->id,
            'saldo' => 0,
            'total_setor' => 0,
            'total_tarik' => 0,
        ]);

        SaldoPelanggan::create([
            'user_id' => $pelanggan2->id,
            'saldo' => 0,
            'total_setor' => 0,
            'total_tarik' => 0,
        ]);

        // Seed Kategori Sampah
        $kategoriSampah = [
            [
                'nama_kategori' => 'Plastik PET',
                'deskripsi' => 'Botol plastik minuman, kemasan makanan',
                'harga_per_kg' => 3000,
                'satuan' => 'kg',
                'status' => 'aktif',
            ],
            [
                'nama_kategori' => 'Plastik PP',
                'deskripsi' => 'Gelas plastik, sedotan, ember',
                'harga_per_kg' => 2500,
                'satuan' => 'kg',
                'status' => 'aktif',
            ],
            [
                'nama_kategori' => 'Kertas HVS',
                'deskripsi' => 'Kertas putih, dokumen, buku',
                'harga_per_kg' => 2000,
                'satuan' => 'kg',
                'status' => 'aktif',
            ],
            [
                'nama_kategori' => 'Kardus',
                'deskripsi' => 'Kardus bekas, box kemasan',
                'harga_per_kg' => 1500,
                'satuan' => 'kg',
                'status' => 'aktif',
            ],
            [
                'nama_kategori' => 'Logam Aluminium',
                'deskripsi' => 'Kaleng minuman, foil aluminium',
                'harga_per_kg' => 5000,
                'satuan' => 'kg',
                'status' => 'aktif',
            ],
            [
                'nama_kategori' => 'Logam Besi',
                'deskripsi' => 'Kaleng besi, paku, kawat',
                'harga_per_kg' => 3500,
                'satuan' => 'kg',
                'status' => 'aktif',
            ],
            [
                'nama_kategori' => 'Botol Kaca',
                'deskripsi' => 'Botol kaca bening, botol parfum',
                'harga_per_kg' => 1000,
                'satuan' => 'kg',
                'status' => 'aktif',
            ],
            [
                'nama_kategori' => 'Koran/Majalah',
                'deskripsi' => 'Koran bekas, majalah, brosur',
                'harga_per_kg' => 1200,
                'satuan' => 'kg',
                'status' => 'aktif',
            ],
        ];

        foreach ($kategoriSampah as $kategori) {
            KategoriSampah::create($kategori);
        }

        echo "Seeding completed!\n";
        echo "Admin: admin@banksampah.com / admin123\n";
        echo "Petugas: petugas1@banksampah.com / petugas123\n";
        echo "Pelanggan: pelanggan1@example.com / pelanggan123\n";
    }
}
