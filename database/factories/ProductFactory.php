<?php

namespace Database\Factories;


use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = Category::inRandomOrder()->limit(1)->first(['id']);
        //Faker laravel created this library to create random data
        $status = ['active','draft'];
        $name = $this->faker->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category_id' => $category? $category->id:null,
            'description' => $this->faker->words(200, true),
            'image_path' => $this->faker->imageUrl(),// i can use image(//folder of images destination) or imageUrl() --> random images URLs
            'status' => $status[rand(0,1)],
            'price' => $this->faker->randomFloat(2,50,2000),
            'quantity' => $this->faker->randomFloat(0,0,30),
        ];
    }
}
