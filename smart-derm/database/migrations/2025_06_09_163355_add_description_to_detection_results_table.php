<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detection_results', function (Blueprint $table) {
            $table->text('description')->nullable()->after('confidence');
        });
    }

    public function down(): void
    {
        Schema::table('detection_results', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
