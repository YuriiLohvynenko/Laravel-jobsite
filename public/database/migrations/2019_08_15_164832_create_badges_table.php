<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('icon');
            $table->enum('type', ['verification', 'licensed']);
            $table->text('description');
            $table->string('pop_up_id');
            $table->timestamps();
        });

        \App\Models\Badge::create([
            'name' => 'True You Badge',
            'icon' => 'icon-feather-user-check',
            'type' => 'verification',
            'pop_up_id' => 'small-dialog-3',
            'description' => 'This tells users you are exactly who you say when applying for jobs.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Digital ID',
            'icon' => 'icon-material-outline-fingerprint',
            'type' => 'verification',
            'pop_up_id' => 'small-dialog-4',
            'description' => 'Confirm you have a valid ID using one of many methods of verification.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Background Check',
            'icon' => 'icon-feather-shield',
            'type' => 'verification',
            'pop_up_id' => 'small-dialog-6',
            'description' => 'Get your background check completed and submitted from the date of sign up.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Mobile',
            'icon' => 'icon-feather-phone-call',
            'type' => 'verification',
            'pop_up_id' => 'small-dialog-7',
            'description' => 'Verify mobile phone. This allows you to receive instant notifications.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Gas and Propane License',
            'icon' => 'icon-feather-alert-circle',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Allows for the installation or repair of piping, petroleum gas tanks and appliances.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Asbestos/Hazardous Waste',
            'icon' => 'icon-feather-alert-triangle',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'The removal of asbestos or any other hazardous waste.',
        ]);

        \App\Models\Badge::create([
            'name' => 'HVAC License',
            'icon' => 'icon-feather-wind',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Technician or construction worker dealing in the installation, repair and maintenance of heating, ventilation and air conditioning.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Residential Contracting License',
            'icon' => 'icon-material-outline-home',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Involves the construction, alteration, and/or imporovement on residential projects.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Commercial Contracting License',
            'icon' => 'icon-material-outline-business',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Involves the construction, alteration, and/or imporovement on commercial projects.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Plumbers License',
            'icon' => 'icon-line-awesome-tint',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Installs almost anything that requires water drainage and hot/cold water supply to homes or commercial spaces.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Carpenters License',
            'icon' => 'icon-feather-scissors',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Constructs various structures using wood based on specialty (ex. "Furniture Maker" or "Siding Installer").',
        ]);

        \App\Models\Badge::create([
            'name' => 'Ironworkers License',
            'icon' => 'icon-feather-anchor',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Involves positioning and securing reinforcing structural steel framework.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Welders License',
            'icon' => 'icon-line-awesome-unlink',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'The fabrication or sculptural process of the joining or altering of metals.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Weatherproofing',
            'icon' => 'icon-feather-cloud-rain',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Specializes in waterproofing and weatherproofing interior or exterior environments.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Irrigation License',
            'icon' => 'icon-feather-thermometer',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Installs, maintains, inspects or designs landscape irrigation systems.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Fencing License',
            'icon' => 'icon-line-awesome-map-signs',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Constructs, erects, alters, or repairs all types of fences, railings, enclosures and barriers.',
        ]);

        \App\Models\Badge::create([
            'name' => 'Electrical License',
            'icon' => 'icon-line-awesome-plug',
            'type' => 'licensed',
            'pop_up_id' => 'small-dialog-1',
            'description' => 'Constructs, erects, alters, or repairs all types of fences, railings, enclosures and barriers.',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badges');
    }
}
