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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string("capital")->nullable();
            $table->string("citizenship")->nullable();
            $table->string("country_code")->unique();
            $table->string("currency")->nullable();
            $table->string("currency_code")->nullable();
            $table->string("currency_sub_unit")->nullable();
            $table->string("full_name")->nullable();
            $table->string("iso_3166_2")->unique();
            $table->string("iso_3166_3")->unique();
            $table->string("name")->unique();
            $table->string("region_code")->nullable();
            $table->string("sub_region_code")->nullable();
            $table->boolean("eea")->default(false);
            $table->string("calling_code")->nullable();
            $table->string("currency_symbol")->nullable();
            $table->string("currency_decimals")->nullable();
            $table->string("flag")->nullable();
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
        Schema::dropIfExists('countries');
    }
};
