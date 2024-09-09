<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetIncreaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_increase_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listing_budget_date_id');
            $table->foreign('listing_budget_date_id')->references('id')->on('listing_budget_date')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('amount');
            $table->text('reason');
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
        Schema::dropIfExists('budget_increase_histories');
    }
}
