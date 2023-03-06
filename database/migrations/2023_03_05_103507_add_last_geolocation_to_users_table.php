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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_known_ip')->nullable();
            $table->string('current_country')->nullable();
            $table->string('current_region')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_latitude')->nullable();
            $table->string('current_longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_known_ip');
            $table->dropColumn('current_country');
            $table->dropColumn('current_region');
            $table->dropColumn('current_city');
            $table->dropColumn('current_latitude');
            $table->dropColumn('current_longitude');
        });
    }
};
