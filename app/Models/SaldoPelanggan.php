<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoPelanggan extends Model
{
    use HasFactory;

    protected $table = 'saldo_pelanggan';

    protected $fillable = [
        'user_id',
        'saldo',
        'total_setor',
        'total_tarik',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method untuk tambah saldo
    public function tambahSaldo($jumlah)
    {
        $this->saldo += $jumlah;
        $this->total_setor += $jumlah;
        $this->save();
    }

    // Helper method untuk kurangi saldo
    public function kurangiSaldo($jumlah)
    {
        if ($this->saldo >= $jumlah) {
            $this->saldo -= $jumlah;
            $this->total_tarik += $jumlah;
            $this->save();
            return true;
        }
        return false;
    }
}