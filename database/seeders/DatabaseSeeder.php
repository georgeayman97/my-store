<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Category::factory(10)->create();
        Product::factory(50)->create();
        // \App\Models\User::factory(10)->create();
        $this->call([
            //CategoriesTableSeeder::class,
           // UsersTableSeeder::class,
        ]);
    }
}
