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
        Schema::create('tutorials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('content')->nullable(); // Pour les tutos texte ou HTML
            $table->enum('file_type', ['document', 'pdf', 'video', 'link', 'text'])->default('text');
            $table->string('file_path', 500)->nullable(); // Chemin du fichier stocké
            $table->unsignedInteger('file_size')->nullable(); // En octets
            $table->string('thumbnail', 500)->nullable(); // Miniature pour vidéos
            $table->unsignedInteger('views_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['branch_id', 'is_published']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorials');
    }
};