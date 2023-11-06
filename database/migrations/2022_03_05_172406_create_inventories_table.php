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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->integer('status');
            $table->integer('type');
            $table->string('reference');

            $table->dateTime('lease_end_at');
            $table->dateTime('lease_begins_at');

            $table->dateTime('date_wanted');

            $table->foreignId('user_id');

            $table->foreignId('tenant_id');

            $table->foreignId('property_id');

            $table->foreignId('appointment_id');

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
        Schema::dropIfExists('inventories');
    }
};
