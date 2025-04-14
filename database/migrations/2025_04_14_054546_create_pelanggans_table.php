<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('no_kontrol')->unique();
            $table->string('name');
            $table->text('alamat')->nullable();
            $table->string('telepon', 16)->nullable();

            // Relasi langsung ke ID dari tabel 'tarifs'
            $table->foreignId('jenis_plg_id')
                  ->constrained('tarifs')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
