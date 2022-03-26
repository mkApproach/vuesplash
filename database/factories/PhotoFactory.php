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
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
