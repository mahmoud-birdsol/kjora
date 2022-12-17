<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('suspensions.table_name'), function (Blueprint $table) {
            $table->id();
            $table->morphs('suspendable');
            $table->enum('state', [
                config('suspensions.suspended'),
                config('suspensions.activated'),
            ])->default(config('suspensions.suspended'));
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
        Schema::dropIfExists('suspensions');
    }
};
