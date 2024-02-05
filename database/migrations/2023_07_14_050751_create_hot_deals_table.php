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
        Schema::create('hot_deals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_id');
            $table->foreign('origin_id')->references('id')->on('locations');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('locations');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('container_size');
            $table->dateTime('eta');
            $table->dateTime('etd');
            $table->dateTime('valid_till')->nullable();
            $table->unsignedInteger('tt')->nullable();
            $table->unsignedInteger('ft')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('amount')->default(0);

            $table->unsignedBigInteger('truck_type_id')->nullable();
            $table->foreign('truck_type_id') ->references('id')->on('truck_types');

            $table->double('max_load_in_ton')->unsigned()->default(0);
            $table->integer('available_trucks')->unsigned()->default(0);
            $table->double('detention_charges_per_hour')->unsigned()->default(0);
            $table->integer('axle')->unsigned()->default(0);

            $table->tinyInteger('route_type')->default(ROUTE_TYPE_SEA);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('hot_deals');
    }
};
