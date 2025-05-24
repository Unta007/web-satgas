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
            $table->text('what_happened')->nullable();
            $table->timestamp('when_happened')->nullable();
            $table->enum('report_role', ['mahasiswa', 'staff', 'dosen'])->nullable(false);
            $table->string('evidence_path')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('predator_role', ['mahasiswa', 'staff', 'dosen'])->nullable(false);
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
