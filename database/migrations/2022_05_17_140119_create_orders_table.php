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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->integer('status');

            $table->dateTime('lease_end_at');
            $table->dateTime('lease_begins_at');

            $table->foreignId('inventory_id');

            $table->float('total_price');
            $table->float('expense_expert');
            $table->float('expense_travel');
            $table->float('cost_expert');

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
        Schema::dropIfExists('orders');
    }
};
