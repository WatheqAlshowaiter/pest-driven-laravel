<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;

beforeEach(function () {
    $this->loggedInUser = User::factory()->create();
    $this->actingAs($this->loggedInUser);
});

function createCourseAndVideos($videosCount = 1): Course
{
    return Course::factory()
        ->has(Video::factory()->count($videosCount))
        ->create();
}

it('shows details for given video', function () {
    // Arrange
    $course = createCourseAndVideos();

    // Act & Assert
    $video = $course->videos()->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeText([
            $video->title,
            $video->description,
            "{$video->duration_in_min}min",
        ]);
});

it('shows given video', function () {
    // Arrange
    $course = createCourseAndVideos();

    // Act & Assert
    $video = $course->videos()->first();
    Livewire::test(VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id);
});

it('shows list of all course videos', function () {
    // Arrange
    $course = createCourseAndVideos(videosCount: 3);

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee([
            ...$course->videos->pluck('title')->toArray(),
        ])->assertSeeHtml([
            route('pages.course-videos', $course->videos[1]),
            route('pages.course-videos', $course->videos[2]),
        ]);
});

it('does not include route for current video', function () {
    // Arrange
    $course = createCourseAndVideos();

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertDontSeeHtml(
            route('pages.course-videos', $course->videos()->first())
        );
});

it('marks a video as completed', function () {
    // Arrange
    $course = createCourseAndVideos();
    $this->loggedInUser->purchasedCourses()->attach($course);

    // Assert
    expect($this->loggedInUser->watchedVideos)->toHaveCount(0);

    // Act
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsCompleted')
        ->call('markVideoAsCompleted')
        ->assertMethodNotWired('markVideoAsCompleted')
        ->assertMethodWired('markVideoAsNotCompleted');
    $this->loggedInUser->refresh();

    // Assert
    expect($this->loggedInUser->watchedVideos)
        ->toHaveCount(1)
        ->first()->title->toEqual($course->videos()->first()->title);
});

it('marks a video as not completed', function () {
    // Arrange
    $course = createCourseAndVideos();
    $this->loggedInUser->purchasedCourses()->attach($course);
    $this->loggedInUser->watchedVideos()->attach($course->videos()->first());

    // Assert
    expect($this->loggedInUser->watchedVideos)->toHaveCount(1);

    // Act
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertMethodWired('markVideoAsNotCompleted')
        ->call('markVideoAsNotCompleted')
        ->assertMethodNotWired('markVideoAsNotCompleted')
        ->assertMethodWired('markVideoAsCompleted');

    $this->loggedInUser->refresh();

    // Assert
    expect($this->loggedInUser->watchedVideos)
        ->toHaveCount(0);
});
