<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('slug')->unique(); // Untuk URL yang SEO-friendly
            $table->longText('description'); // Untuk konten dari rich text editor
            $table->string('image')->nullable(); // Path ke gambar artikel
            $table->timestamp('published_at')->nullable(); // Tanggal rilis
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
