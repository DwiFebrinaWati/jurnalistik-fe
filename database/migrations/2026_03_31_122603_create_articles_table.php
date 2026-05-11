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
        Schema::create('articles', function (Blueprint $table) {
            $table->id('article_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            
            // Konten Utama
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('photo')->nullable();

            // Metadata & Status
            $table->enum('status', ['draft', 'submitted', 'accepted', 'rejected', 'published', 'archived'])->default('draft');
            $table->integer('views')->default(0); // Untuk tracking jumlah views

            // Audit Trail (Log Metadata)
            $table->timestamp('publish_date')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users', 'user_id')->onDelete('set null'); // ID Editor yang menyetujui
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
