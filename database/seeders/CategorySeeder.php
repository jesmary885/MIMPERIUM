<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Hogar',
                'slug' => Str::slug('Hogar'),
                'image' => 'categories/hogar.jpg',
            ],
            [
                'name' => 'Tecnología',
                'slug' => Str::slug('Tecnología'),
                'image' => 'categories/tecnologia.jpg',
            ],

            [
                'name' => 'Digital',
                'slug' => Str::slug('Digital'),
                'image' => 'categories/digital.jfif',
  
            ],

            [
                'name' => 'Cuidado personal',
                'slug' => Str::slug('Cuidado personal'),
                'image' => 'categories/cuidado.jpg',
   
            ],

        ];

        foreach ($categories as $category) {
            $category = Category::create($category);

            $brands = Brand::factory(4)->create();

            foreach ($brands as $brand) {
                $brand->categories()->attach($category->id);
            }
        }

    }
}
