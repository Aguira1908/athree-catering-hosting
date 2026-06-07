<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catering_menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('nama_menu');
            $table->string('kategori');
            $table->decimal('harga', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->integer('stok')->default(0);
            $table->string('status')->default('tersedia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catering_menu');
    }
};
