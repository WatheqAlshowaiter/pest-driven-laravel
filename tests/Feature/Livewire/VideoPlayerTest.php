<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;

test('shows details for given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()->state([
            'title' => 'Video Title',
            'description' => 'Video description',
            'duration' => 10,
        ]))
        ->create();

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSeeText([
            'Video Title',
            'Video description',
            '10min',
        ]);
});

test('shows given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()->state([
            'vimeo_id' => 'vimeo-id',
        ]))
        ->create();

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee('<iframe src="https://player.vimeo.com/video/vimeo-id"', false);
});
