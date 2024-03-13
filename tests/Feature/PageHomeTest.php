<?php

use App\Models\Course;
use function Pest\Laravel\get;

it('shows courses overview', function () {
    // Arrange
    Course::factory()->create([
        'title' => 'Course A',
        'description' => 'Description Course A',
    ]);
    Course::factory()->create([
        'title' => 'Course B',
        'description' => 'Description Course B',
    ]);
    Course::factory()->create([
        'title' => 'Course C',
        'description' => 'Description Course C',
    ]);

    // Act & Assert
    get(route('home'))
        ->assertSeeText([
            'Course A',
            'Description Course A',
            'Course B',
            'Description Course B',
            'Course C',
            'Description Course C',
        ]);
});

it('shows only released courses', function () {
    // Arrange
    // Act
    // Assert
});

it('shows courses by release date', function () {
    // Arrange
    // Act
    // Assert
});
