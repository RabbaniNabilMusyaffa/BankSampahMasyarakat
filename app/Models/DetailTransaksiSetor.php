<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiSetor extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_setor';

    protected $fillable = [
        'transaksi_setor_id',
        'kategori_sampah_id',
        'berat',
        'harga_per_kg',
        'subtotal',
    ];

    // Relasi ke Transaksi Setor
    public function transaksiSetor()
    {
        return $this->belongsTo(TransaksiSetor::class);
    }

    // Relasi ke Kategori Sampah
    public function kategoriSampah()
    {
        return $this->belongsTo(KategoriSampah::class, 'kategori_sampah_id');
    }


}