<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Deleting All old records
        \DB::table('categories')->delete();

        // Creating new records
        $category = new Category();
        $category->name = 'Additions & Remodels';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Auto Care & Maintenence';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Asbestos/Hazardous Waste';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Carpentry & Woodworking';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Cleaning Services';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Commercial Contracting';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Designers & Decorators';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Event Planning';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Engineers, Architects & Builders';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Energy Efficiency';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Electrical';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Flooring';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Fencing';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Heating & Cooling';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Roadside Assistance';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Residential Contracting';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Designers & Decorators';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Insulation & Drywall';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Removalist';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Gardening & Landscaping';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Personal Shopper';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Handyman Services';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Home Appraiser & Inspector';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Foundations';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Green Home Improvement';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Moving & Storage';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Remodeling';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Painting & Staining';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Plumbing';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Gas & Propane';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Ironwork';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Welding';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Weatherproofing';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Irrigation';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Roofing';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Siding';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Swimming Pools & Hot Tubs';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Home Security';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Pest Control';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Recovery Services';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Web Development';
        $category->slug = $this->slugify($category->name);
        $category->save();

        $category = new Category();
        $category->name = 'Legal';
        $category->slug = $this->slugify($category->name);
        $category->save();

    }
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
