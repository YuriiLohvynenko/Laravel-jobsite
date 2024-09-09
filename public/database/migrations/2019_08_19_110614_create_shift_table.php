<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('listing_id')->nullable();
            $table->unsignedInteger('budget_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });
        Schema::table('listing_budget_date', function (Blueprint $table) {
            $table->double('increased_budget')->nullable()->default(null)->after('budget');
            $table->enum('status', ['pending', 'completed'])->default('pending')->after('increased_budget');
        });

        \DB::statement("ALTER TABLE `listings` CHANGE `status` `status` ENUM('pending','accepted','rejected','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
