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
        Schema::table('inventories', function (Blueprint $table) {
            $table->date('lease_end_at')->change();
            $table->date('lease_begins_at')->change();
            $table->date('date_wanted')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dateTime('lease_end_at')->change();
            $table->dateTime('lease_begins_at')->change();
            $table->dateTime('date_wanted')->change();
        });
    }
};
