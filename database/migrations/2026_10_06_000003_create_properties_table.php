<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            // Keep indexed strings bounded so utf8mb4 composite indexes stay below MySQL's 3072-byte limit.
            $table->string('city', 50)->default('Damascus');
            $table->string('neighborhood', 100);
            $table->string('address')->nullable();
            $table->string('purpose', 20); // rent, sale
            $table->string('category', 20); // residential, commercial
            $table->decimal('price', 14, 2);
            $table->string('currency', 3)->default('USD');
            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('floor')->nullable();
            $table->unsignedInteger('area')->nullable();
            $table->boolean('furnished')->default(false);
            $table->boolean('reward_available')->default(false);
            $table->json('media')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('last_confirmed_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'city', 'neighborhood', 'purpose']);
        });
    }

    public function down(): void { Schema::dropIfExists('properties'); }
};
