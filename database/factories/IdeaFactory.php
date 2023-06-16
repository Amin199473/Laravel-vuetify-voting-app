<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = ucwords($this->faker->words(4, true));
        $slug = Str::slug($title,'-');
        return [
            'user_id' => $this->faker->numberBetween(1,20),
            'category_id' => $this->faker->numberBetween(1,5),
            'status_id' => $this->faker->numberBetween(1,5),
            'title' => $title,
            'slug' => $slug,
            'description' => $this->faker->paragraph(5),
        ];
    }
}
