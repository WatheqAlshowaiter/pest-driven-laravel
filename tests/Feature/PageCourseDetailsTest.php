<?php

use App\Models\Course;

use function Pest\Laravel\get;

it('shows course details', function () {
    $course = Course::factory()->create([
        'tagline' => 'Course tagline',
        'image' => 'image.png',
        'learnings' => [
            'Learn laravel routes',
            'Learn laravel views',
            'Learn laravel commands',
        ],
    ]);

    // Act & Assert
    get(route('course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            'Course tagline',
            'Learn laravel routes',
            'Learn laravel views',
            'Learn laravel commands',
        ])
        ->assertSee('image.png');
});

it('shows course video count', function () {
});
