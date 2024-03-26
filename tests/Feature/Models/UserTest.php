<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;

it('has courses', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory()->count(2))
        ->create();

    // Act & Assert
    expect($user->courses)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Course::class);
});

it('has videos', function () {
    // Arrange
    $user = User::factory()
        ->has(Video::factory()->count(2), 'videos')
        ->create();

    // Act & Assert
    expect($user->videos)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Video::class);
});
