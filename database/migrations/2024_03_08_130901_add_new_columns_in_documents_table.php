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
        Schema::table('booking_documents', function (Blueprint $table) {
            // Rename filename column to master_bill_lading
            $table->renameColumn('filename', 'master_bill_lading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_documents', function (Blueprint $table) {
            //
        });
    }
};
