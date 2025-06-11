<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_user_id_to_detection_results_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detection_results', function (Blueprint $table) {
            // Menambahkan foreign key ke tabel users
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('detection_results', function (Blueprint $table) {
            // Menghapus foreign key
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
