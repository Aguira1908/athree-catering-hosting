<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_pesanan', function (Blueprint $table) {
            $table->id('id_tracking');
            $table->unsignedBigInteger('id_pesanan');
            $table->string('status');
            $table->text('deskripsi');
            $table->datetime('waktu');

            $table->foreign('id_pesanan')->references('id_pesanan')->on('catering_pesanan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_pesanan');
    }
};
