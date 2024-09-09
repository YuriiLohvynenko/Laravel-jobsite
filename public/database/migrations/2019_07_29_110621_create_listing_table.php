<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('category_id')->nullable()->default(null);
            $table->string('job_title')->nullable()->default(null);
            $table->longText('description')->nullable()->default(null);
            $table->enum('materials', ['included_in_budget','not_required','not_included'])->default('included_in_budget');
            $table->dateTime('date_time')->nullable()->default(null);
            $table->double('budget')->nullable()->default(0.0);
            $table->enum('job_location', ['on_location', 'online'])->default('on_location');
            $table->enum('immediate_assistance', ['not_required', 'required'])->default('not_required');
            $table->text('address')->nullable()->default(null);
            $table->longText('street_address')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('state')->nullable()->default(null);
            $table->integer('zip_code')->nullable()->default(null);
            $table->string('latitude')->nullable()->default(null);
            $table->string('longitude')->nullable()->default(null);
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
        Schema::dropIfExists('listings');
    }
}
