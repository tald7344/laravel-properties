<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->unique()->after('email');
            $table->string('role')->default('tenant')->after('phone');
            $table->boolean('phone_verified')->default(false)->after('role');
            $table->boolean('is_verified_owner')->default(false)->after('phone_verified');
        });
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone');
            $table->text('message')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type');
            $table->text('details')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
        });
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan')->default('monthly');
            $table->decimal('amount', 12, 2);
            $table->string('sham_cash_reference');
            $table->string('status')->default('pending');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions'); Schema::dropIfExists('reports'); Schema::dropIfExists('inquiries');
        Schema::table('users', function (Blueprint $table) { $table->dropColumn(['phone','role','phone_verified','is_verified_owner']); });
    }
};
