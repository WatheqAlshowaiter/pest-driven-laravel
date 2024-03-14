<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->slug(),
            'tagline' => fake()->sentence(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'image' => 'image.png',
            'learnings' => ['Learn A', 'Learn B', 'Learn C'],
        ];
    }

    public function released(?Carbon $releasedAt = null): self
    {
        return $this->state(fn (array $attributes) => ['released_at' => $releasedAt ?? Carbon::now()]);
    }
}
