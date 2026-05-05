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
        Schema::create('task_orders', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi_tugas');
            $table->enum('status', ['pending','proses','selesai'])->default('pending');
            $table->date('tgl_input');
            $table->date('tgl_selesai')->nullable();
            $table->text('catatan_hasil')->nullable();
        
            $table->foreignId('id_admin')->constrained('users');
            $table->foreignId('id_teknisi')->nullable()->constrained('users');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_orders');
    }
};
