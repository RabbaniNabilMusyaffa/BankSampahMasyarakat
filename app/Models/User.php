<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'foto_profil',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Saldo Pelanggan
    public function saldo()
    {
        return $this->hasOne(SaldoPelanggan::class);
    }

    // Relasi ke Transaksi Setor (sebagai pelanggan)
    public function transaksiSetor()
    {
        return $this->hasMany(TransaksiSetor::class, 'user_id');
    }

    // Relasi ke Transaksi Setor (sebagai petugas)
    public function transaksiSetorDiproses()
    {
        return $this->hasMany(TransaksiSetor::class, 'petugas_id');
    }

    // Relasi ke Transaksi Tarik (sebagai pelanggan)
    public function transaksiTarik()
    {
        return $this->hasMany(TransaksiTarik::class, 'user_id');
    }

    // Relasi ke Transaksi Tarik (sebagai petugas)
    public function transaksiTarikDiproses()
    {
        return $this->hasMany(TransaksiTarik::class, 'petugas_id');
    }

    // Relasi ke Notifikasi
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Relasi ke Activity Logs
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }
}