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
        Schema::create('request_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_position_request_id')->constrained()
                ->cascadeOnDelete()
                ->references('id')
                ->on('team_position_requests');

            $table->foreignId('player_id')->constrained()
                ->cascadeOnDelete()
                ->references('id')
                ->on('users');

            $table->dateTime('applied_at')->nullable();
            $table->dateTime('approved_at')->nullable();
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
        Schema::dropIfExists('request_applications');
    }
};
