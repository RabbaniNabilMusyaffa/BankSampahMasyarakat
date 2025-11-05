<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSampah extends Model
{
    use HasFactory;

    protected $table = 'kategori_sampah';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'harga_per_kg',
        'satuan',
        'status',
    ];

    // Relasi ke Detail Transaksi Setor
    public function detailTransaksiSetor()
    {
        return $this->hasMany(DetailTransaksiSetor::class);
    }
}