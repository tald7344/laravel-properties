<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $t) {
            $t->string('route_name', 150)->nullable()->after('label');
            $t->index('route_name');
        });
    }
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $t) {
            $t->dropIndex(['route_name']);
            $t->dropColumn('route_name');
        });
    }
};
