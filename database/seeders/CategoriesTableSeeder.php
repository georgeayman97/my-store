<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ORM: Eloquent Model
        Category::create([
            'name' => 'category model',
            'slug' => 'category-model',
            'status' => 'draft',
        ]);

        return;
        
        //Query Builder
        DB::connection('mysql')->table('categories')->insert([
            'name' => 'my first category',
            'slug' => 'my-first-category',
            'status' => 'active',
        ]);

        //SQL Commands

    }
}
