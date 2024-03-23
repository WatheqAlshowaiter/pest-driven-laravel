<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;

use function Pest\Laravel\get;

it('cannot be accessed by a guest', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    get(route('pages.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    login()
        ->get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});

it('shows first course video by default', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()->state(['title' => 'My Video']))
        ->create();

    // Act & Assert
    login()
        ->get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeText('My Video');
});

it('shows provided course video', function () {
    // Arrange
    $course = Course::factory()
        ->has(
            Video::factory()
                ->count(2)
                ->sequence(
                    ['title' => 'First Video'],
                    ['title' => 'Second Video']
                )
        )
        ->create();

    // Act & Assert
    login()
        ->get(route('pages.course-videos', [
            'course' => $course,
            'video' => $course->videos()->orderByDesc('id')->first(),
        ]))
        ->assertOk()
        ->assertSeeText('Second Video');
});
