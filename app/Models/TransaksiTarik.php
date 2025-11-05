<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiTarik extends Model
{
    use HasFactory;

    protected $table = 'transaksi_tarik';

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'petugas_id',
        'tanggal_request',
        'tanggal_validasi',
        'jumlah',
        'status',
        'catatan',
        'alasan_penolakan',
    ];

    protected $casts = [
        'tanggal_request' => 'date',
        'tanggal_validasi' => 'date',
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

    // Generate kode transaksi otomatis
    public static function generateKodeTransaksi()
    {
        $prefix = 'TRK';
        $date = date('Ymd');
        $last = self::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    // Scope untuk filter status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
}