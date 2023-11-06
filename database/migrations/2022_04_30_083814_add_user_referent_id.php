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
        // Add new type
        Schema::table('inventories', function ($table) {
            $table->integer('user_referent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove column
        Schema::table('inventories', function ($table) {
            $table->dropColumn('user_referent_id');
        });
    }
};
