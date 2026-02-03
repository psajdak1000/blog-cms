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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        
        // To łączy post z kategorią (jeśli usuniesz kategorię, znikną też posty)
        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        
        $table->string('title');               // Tytuł
        $table->string('slug')->unique();      // Adres URL
        $table->string('image')->nullable();   // Zdjęcie (może być puste)
        $table->text('content');               // Długa treść artykułu
        $table->string('status')->default('draft'); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
