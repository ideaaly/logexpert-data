<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->string('owner_name');
            $table->string('address1');
            $table->string('address2');
            $table->string('building_number');
            $table->string('appt_number');
            $table->string('zip_code');
            $table->string('city');
            $table->string('country');

            $table->integer('year_construction');
            $table->float('surface');

            $table->string('water');
            $table->string('heating');

            $table->boolean('is_furnished');
            $table->boolean('has_parking');
            $table->string('parking_number');
            $table->boolean('has_cellar');
            $table->string('cellar_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
