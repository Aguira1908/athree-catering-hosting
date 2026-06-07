<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingPesanan extends Model
{
    protected $table = 'tracking_pesanan';
    protected $primaryKey = 'id_tracking';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan', 'status', 'deskripsi', 'waktu'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}
