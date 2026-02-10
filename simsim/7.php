<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';

    protected $fillable = [
        'user_id',
        'alat_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tgl_dikembalikan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}
