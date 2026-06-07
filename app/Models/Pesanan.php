<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'catering_pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_customer', 'tanggal_pesan', 'tanggal_kirim',
        'alamat_kirim', 'total_harga', 'status_pesanan',
        'status_bayar', 'bukti_bayar', 'catatan'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan');
    }

    public function tracking()
    {
        return $this->hasMany(TrackingPesanan::class, 'id_pesanan');
    }
}
