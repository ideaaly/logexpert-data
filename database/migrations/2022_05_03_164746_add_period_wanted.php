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
            $table->string('period_wanted')->after('date_wanted');
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
            $table->dropColumn('period_wanted');
        });
    }
};
