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
        Schema::create('match_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_team_id')->nullable()
                ->constrained()
                ->references('id')
                ->on('teams')
                ->nullOnDelete();

            $table->foreignId('away_team_id')->nullable()
                ->constrained()
                ->references('id')
                ->on('teams')
                ->nullOnDelete();

            $table->foreignId('winning_team_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->references('id')
                ->on('teams');

            $table->string('final_score')->nullable();

            $table->dateTime('match_date')->nullable();
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
        Schema::dropIfExists('match_games');
    }
};
