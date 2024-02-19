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
            $table->integer('is_quoted')->default(0)->after('etd');
            $table->unsignedBigInteger('quoted_by')->nullable()->after('is_quoted');
            $table->foreign('quoted_by')->references('id')->on('users');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quick_request_forms', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['quoted_by']);

            // Then, drop the column
            $table->dropColumn('quoted_by');
            $table->dropColumn('is_quoted');
        });
    }
};
