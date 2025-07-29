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
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kontak, cth: "Hotline Satgas PPKPT"
            $table->enum('type', ['Bantuan Internal', 'Lembaga Eksternal']);
            $table->string('contact_info'); // Nomor telepon, link WhatsApp, dll.
            $table->text('description')->nullable(); // Penjelasan singkat
            $table->string('icon')->default('bi-telephone-fill'); // Ikon Bootstrap
            $table->boolean('is_active')->default(true); // Status tampil/sembunyi
            $table->integer('order')->default(0); // Urutan tampil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};
