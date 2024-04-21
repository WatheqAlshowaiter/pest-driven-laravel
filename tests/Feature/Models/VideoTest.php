<?php

use App\Models\Course;
use App\Models\User;
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

it('tells if current user not yet watched current video', function () {
    //Arrange
    $video = Video::factory()->make();

    //Act & Assert
    login();
    expect($video->alreadyWatchedByCurrentUser())->toBeFalse();
});

it('tells if current user already watched current video', function () {
    //Arrange
    $user = User::factory()
        ->has(Video::factory(), 'watchedVideos')
        ->create();

    // Act & Assert
    login($user);
    expect($user->watchedVideos()->first()->alreadyWatchedByCurrentUser())->toBeTrue();
});
