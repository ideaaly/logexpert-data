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
        Schema::table('users', function ($table) {
            $table->integer('expert_level')->after('current_team_id');
            $table->string('g_calid')->after('profile_photo_path');
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
        Schema::table('users', function ($table) {
            $table->dropColumn('expert_level');
            $table->dropColumn('g_calid');
        });
    }
};
