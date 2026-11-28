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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kantong_id')->constrained('kantongs')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->enum('jenis', ['pemasukan', 'pengeluaran']); // Pemasukan atau Pengeluaran
            $table->decimal('nominal', 15, 2); // Nominal uang transaksi
            $table->date('tanggal_transaksi'); // Tanggal terjadinya transaksi
            $table->text('catatan')->nullable(); // Catatan tambahan (boleh kosong)
            $table->softDeletes(); // Agar data aman saat transaksi dihapus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};