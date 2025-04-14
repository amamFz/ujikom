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
        Schema::create('pemakaians', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->default(date('Y'));
            $table->tinyInteger('bulan')->default(date('n'));
            $table->string('no_kontrol_id');
            $table->integer('meter_awal');
            $table->integer('meter_akhir');
            $table->integer('jumlah_pakai');
            $table->decimal('biaya_beban_pemakai', 10, 2);
            $table->decimal('biaya_pemakaian',10,2);
            $table->timestamps();

            $table->foreign('no_kontrol_id')
                ->references('no_kontrol')
                ->on('pelanggans')
                ->onDelete('cascade');
            $table->unique(['tahun', 'bulan', 'no_kontrol_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaians');
    }
};
