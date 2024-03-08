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
            $table->string('house_bill_lading')->nullable()->after('master_bill_lading');
            $table->string('certificate_of_origin')->nullable()->after('house_bill_lading');
            $table->string('commercial_invoice')->nullable()->after('certificate_of_origin');
            $table->string('packing_list')->nullable()->after('commercial_invoice');
            $table->string('other_document')->nullable()->after('packing_list');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_documents', function (Blueprint $table) {
            $table->dropColumn(['house_bill_lading', 'certificate_of_origin', 'commercial_invoice', 'packing_list', 'other_document']);
        });
    }
};
