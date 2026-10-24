<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('property_id')->nullable()->change();
            $table->string('subject_type')->default('property');
            $table->string('subject_name')->nullable();
            $table->string('subject_contact')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['subject_type', 'subject_name', 'subject_contact']);
            $table->foreignId('property_id')->nullable(false)->change();
        });
    }
};
