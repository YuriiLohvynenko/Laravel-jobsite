<?php

use App\Models\Specialities;
use Illuminate\Database\Seeder;

class UserSpecialitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Deleting All old records
        \DB::table('specialities')->delete();

        // Creating new records
        $specialities = Specialities::create(
                ['name' => 'Additions & Remodels']
        );
        $specialities = Specialities::create(
                ['name' => 'Heating & Cooling']
        );
        $specialities = Specialities::create(
                ['name' => 'Engineers, Architects & Builders']
        );
        $specialities = Specialities::create(
                ['name' => 'Roadside Assistance']
        );
        $specialities = Specialities::create(
                ['name' => 'Carpentry & Woodworking']
        );
        $specialities = Specialities::create(
                ['name' => 'Auto Care & Maintenence']
        );
        $specialities = Specialities::create(
                ['name' => 'Cleaning Services']
        );
        $specialities = Specialities::create(
                ['name' => 'Designers & Decorators']
        );
        $specialities = Specialities::create(
                ['name' => 'Insulation & Drywall']
        );
        $specialities = Specialities::create(
                ['name' => 'Energy Efficiency']
        );
        $specialities = Specialities::create(
                ['name' => 'Removalist']
        );
        $specialities = Specialities::create(
                ['name' => 'Gardening & Landscaping']
        );
        $specialities = Specialities::create(
                ['name' => 'Personal Shopper']
        );
        $specialities = Specialities::create(
                ['name' => 'Handyman Services']
        );
        $specialities = Specialities::create(
                ['name' => 'Home Appraiser & Inspector']
        );
        $specialities = Specialities::create(
                ['name' => 'Event Planning']
        );
        $specialities = Specialities::create(
                ['name' => 'Fencing']
        );
        $specialities = Specialities::create(
                ['name' => 'Flooring']
        );
        $specialities = Specialities::create(
                ['name' => 'Foundations']
        );
        $specialities = Specialities::create(
                ['name' => 'Green Home Improvement']
        );
        $specialities = Specialities::create(
                ['name' => 'Moving & Storage']
        );
        $specialities = Specialities::create(
                ['name' => 'Remodeling']
        );
        $specialities = Specialities::create(
                ['name' => 'Painting & Staining']
        );
        $specialities = Specialities::create(
                ['name' => 'Plumbing']
        );
        $specialities = Specialities::create(
                ['name' => 'Gas & Propane']
        );
        $specialities = Specialities::create(
                ['name' => 'Asbestos/Hazardous Waste']
        );
        $specialities = Specialities::create(
                ['name' => 'Residential Contracting']
        );
        $specialities = Specialities::create(
                ['name' => 'Commercial Contracting']
        );
        $specialities = Specialities::create(
                ['name' => 'Ironwork']
        );
        $specialities = Specialities::create(
                ['name' => 'Welding']
        );
        $specialities = Specialities::create(
                ['name' => 'Weatherproofing']
        );
        $specialities = Specialities::create(
                ['name' => 'Irrigation']
        );
        $specialities = Specialities::create(
                ['name' => 'Electrical']
        );
        $specialities = Specialities::create(
                ['name' => 'Roofing']
        );
        $specialities = Specialities::create(
                ['name' => 'Siding']
        );
        $specialities = Specialities::create(
                ['name' => 'Swimming Pools & Hot Tubs']
        );
        $specialities = Specialities::create(
                ['name' => 'Home Security']
        );
        $specialities = Specialities::create(
                ['name' => 'Pest Control']
        );
        $specialities = Specialities::create(
                ['name' => 'Recovery Services']
        );
        $specialities = Specialities::create(
                ['name' => 'Web Development']
        );
        $specialities = Specialities::create(
                ['name' => 'Legal']
        );
    }
}
