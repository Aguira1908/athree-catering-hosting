<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pesanan');
            $table->string('metode_pembayaran');
            $table->string('kode_pembayaran')->nullable();
            $table->decimal('jumlah_bayar', 12, 2);
            $table->datetime('tanggal_bayar')->nullable();
            $table->string('status_verifikasi')->default('pending');
            $table->text('keterangan')->nullable();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('catering_pesanan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
