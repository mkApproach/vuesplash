<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\User;

class PhotoFactory extends Factory
{
    
    public function definition()
    {
      //  Storage::fake('photos');

        return [
            'id' => Str::random(12),
            'user_id' => fn() => User::factory()->create()->id,
            'filename' => Str::random(12) . '.jpg',
            
            'major_id' => Str::random(10),          // 大分類id
            'middle_id' => Str::random(10),         // 中分類ID
            'subcategory_id' => Str::random(10),    // 小分類ID
            'productname_j' => Str::random(10),     // 商品名（日本語）
            'price' => 0,                           // 価格 -2147483647 〜 2147483647 まで

            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
