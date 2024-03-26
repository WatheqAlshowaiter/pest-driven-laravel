<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;

test('shows details for given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    $video = $course->videos()->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeText([
            $video->title,
            $video->description,
            "{$video->duration_in_min}min",
        ]);
});

test('shows given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    $video = $course->videos()->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id);
});

test('shows list of all course videos', function () {
    // Arrange
    $course = Course::factory()
        ->has(
            Video::factory()
                ->count(3)
                ->sequence(
                    ['title' => 'First Video'],
                    ['title' => 'Second Video'],
                    ['title' => 'Third Video']
                )
        )
        ->create();

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee([
            'First Video',
            'Second Video',
            'Third Video',
        ])->assertSeeHtml([
            route('pages.course-videos', Video::where('title', 'First Video')->first()),
            route('pages.course-videos', Video::where('title', 'Second Video')->first()),
            route('pages.course-videos', Video::where('title', 'Third Video')->first()),
        ]);
});

test('mark a video as completed', function () {
    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()
        ->has(Video::factory()->state(['title' => 'Course Video']))
        ->create();

    $user->courses()->attach($course);

    // Assert
    expect($user->videos)->toHaveCount(0);

    // Act
    login($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->call('markVideoAsCompleted');
    $user->refresh();

    // Assert
    expect($user->videos)
        ->toHaveCount(1)
        ->first()->title->toEqual('Course Video');
});

test('mark a video as not completed', function () {
    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()
        ->has(Video::factory()->state(['title' => 'Course Video']))
        ->create();

    $user->courses()->attach($course);
    $user->videos()->attach($course->videos()->first());

    // Assert
    expect($user->videos)->toHaveCount(1);

    // Act
    login($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->call('markVideoAsNotCompleted');
    $user->refresh();

    // Assert
    expect($user->videos)
        ->toHaveCount(0);
});
