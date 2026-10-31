<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 120)->unique();
            $table->boolean('is_published')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('legal_page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('legal_page_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('title', 255);
            $table->longText('content');
            $table->timestamps();
            $table->unique(['legal_page_id', 'language_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_page_translations');
        Schema::dropIfExists('legal_pages');
    }
};
