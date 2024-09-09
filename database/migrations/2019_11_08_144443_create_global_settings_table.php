<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('commission_rate');
            $table->integer('cashback_rate');
            $table->string('paypal_email');
            $table->timestamps();
        });

        $global = new \App\Models\GlobalSettings();
        $global->commission_rate = 1;
        $global->cashback_rate = 1;
        $global->paypal_email = "paypal@gmail.com";
        $global->save();

        Schema::table('admins', function (Blueprint $table) {
            $table->string('mobile_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_settings');
    }
}
