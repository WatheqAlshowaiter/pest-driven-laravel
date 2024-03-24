<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'slug' => fake()->slug(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'duration_in_min' => fake()->numberBetween(1, 99),
            'vimeo_id' => fake()->uuid(),
        ];
    }
}
