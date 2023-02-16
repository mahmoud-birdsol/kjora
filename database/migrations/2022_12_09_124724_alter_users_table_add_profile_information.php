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
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('club_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('position_id')->nullable()->constrained()->nullOnDelete();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();

            $table->string('identity_issue_country')->nullable();
            $table->string('identity_type')->nullable();
            $table->string('identity_front_image')->nullable();
            $table->string('identity_back_image')->nullable();
            $table->string('identity_selfie_image')->nullable();

            $table->string('accepted_terms_and_conditions_version')->nullable();
            $table->string('accepted_privacy_policy_version')->nullable();
            $table->string('accepted_cookie_policy_version')->nullable();

            $table->timestamp('date_of_birth')->nullable();
            $table->timestamp('identity_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('accepted_terms_and_conditions_at')->nullable();
            $table->timestamp('accepted_privacy_policy_at')->nullable();
            $table->timestamp('accepted_cookie_policy_at')->nullable();
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
            $table->dropColumn('country_id');
            $table->dropColumn('favorite_club_id');
            $table->dropColumn('position_id');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('gender');
            $table->dropColumn('avatar');
            $table->dropColumn('identity_type');
            $table->dropColumn('identity_front_image');
            $table->dropColumn('identity_back_image');
            $table->dropColumn('accepted_terms_and_conditions_version');
            $table->dropColumn('accepted_privacy_policy_version');
            $table->dropColumn('accepted_cookie_policy_version');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('identity_verified_at');
            $table->dropColumn('phone_verified_at');
            $table->dropColumn('accepted_terms_and_conditions_at');
            $table->dropColumn('accepted_privacy_policy_at');
            $table->dropColumn('accepted_cookie_policy_at');
        });
    }
};
