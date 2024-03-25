<?php

use App\Models\Course;
use App\Models\Video;

it('belongs to a course', function () {
    // Arrange
    $video = Video::factory()
        ->has(Course::factory())
        ->create();

    // Act & Assert
    expect($video->course)
        ->toBeInstanceOf(Course::class);
});

test('gives back readable video duration', function () {
    //Arrange
    $video = Video::factory()->make(['duration_in_min' => 10]);

    //Act & Assert
    expect($video->getReadableDuration())->toBe('10min');
});
