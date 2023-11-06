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
            $table->dateTime('lease_end_at')->nullable()->change();
            $table->dateTime('lease_begins_at')->nullable()->change();
            $table->dateTime('date_wanted')->nullable()->change();
            $table->string('key_notes')->nullable()->change();
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
            $table->dateTime('lease_end_at')->nullable(false)->change();
            $table->dateTime('lease_begins_at')->nullable(false)->change();
            $table->dateTime('date_wanted')->nullable(false)->change();
            $table->string('key_notes')->nullable(false)->change();
        });
    }
};
