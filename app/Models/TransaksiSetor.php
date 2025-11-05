<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSetor extends Model
{
    use HasFactory;

    protected $table = 'transaksi_setor';

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'petugas_id',
        'tanggal_setor',
        'total_berat',
        'total_harga',
        'catatan',
    ];

    protected $casts = [
        'tanggal_setor' => 'date',
    ];

    // Relasi ke User (Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke User (Petugas)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Relasi ke Detail Transaksi Setor
    public function detailSetor()
    {
        return $this->hasMany(DetailTransaksiSetor::class);
    }

    // Generate kode transaksi otomatis
    public static function generateKodeTransaksi()
    {
        $prefix = 'STR';
        $date = date('Ymd');
        $last = self::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}