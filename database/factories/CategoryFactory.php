<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        //SELECT id FROM categories ORDER BY RAND() LIMIT 1
        // get returns collection

        $category = DB::table('categories')->inRandomOrder()->limit(1)->first(['id']);
        //Faker laravel created this library to create random data
        $status = ['active','draft'];
        $name = $this->faker->words(2, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => $category? $category->id:null,
            'description' => $this->faker->words(200, true),
            'image_path' => $this->faker->imageUrl(),// i can use image(//folder of images destination) or imageUrl() --> random images URLs
            'status' => $status[rand(0,1)],
        ];
    }
}
