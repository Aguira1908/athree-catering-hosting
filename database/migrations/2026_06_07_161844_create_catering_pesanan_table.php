<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catering_pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_customer');
            $table->datetime('tanggal_pesan');
            $table->date('tanggal_kirim');
            $table->text('alamat_kirim');
            $table->decimal('total_harga', 12, 2);
            $table->string('status_pesanan')->default('pending');
            $table->string('status_bayar')->default('pending');
            $table->string('bukti_bayar')->nullable();
            $table->text('catatan')->nullable();

            $table->foreign('id_customer')->references('id_customer')->on('customer')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catering_pesanan');
    }
};
