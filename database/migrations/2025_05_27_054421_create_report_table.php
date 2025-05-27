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
        Schema::create('report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('what_happened'); // Dijadikan non-nullable jika wajib
            $table->timestamp('when_happened'); // Dijadikan non-nullable jika wajib
            $table->enum('reporter_role', ['mahasiswa', 'staff', 'dosen', 'lainnya']); // Tidak nullable, pelapor harus memilih

            $table->enum('perpetrator_role', ['mahasiswa', 'staff', 'dosen', 'lainnya', 'tidak_diketahui'])->nullable(); // Nullable karena mungkin tidak tahu

            $table->string('evidence_path')->nullable(); // Bukti bisa jadi opsional atau wajib, sesuaikan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report');
    }
};
