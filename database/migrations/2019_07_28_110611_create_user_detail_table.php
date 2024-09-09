<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('user_specialities_id')->nullable()->default(null);
            $table->string('paypal_email')->nullable()->default(null);
            $table->integer('hourly_rate')->nullable()->default(0);
            $table->string('previous_job_titles')->nullable()->default(null);
            $table->longText('introduction')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->string('latitude')->nullable()->default(null);
            $table->string('longitude')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('state')->nullable()->default(null);
            $table->integer('zip_code')->nullable()->default(null);
            $table->string('mobile_no')->nullable()->default(null);
            $table->string('mobile_verification_code')->nullable()->default(null);
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
        Schema::dropIfExists('user_details');
    }
}
