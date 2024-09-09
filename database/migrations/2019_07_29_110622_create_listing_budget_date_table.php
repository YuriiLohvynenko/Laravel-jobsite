<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingBudgetDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_budget_date', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('listing_id')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->double('budget')->nullable();
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
        Schema::dropIfExists('listing_budget_date');
    }
}
