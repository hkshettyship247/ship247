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
        Schema::table('quick_request_forms', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->integer('is_quoted')->default(0)->after('etd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quick_request_forms', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['user_id']);

            // Then, drop the column
            $table->dropColumn('user_id');
            $table->dropColumn('is_quoted');
        });
    }
};
