<?php

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;

use function Pest\Laravel\get;

it('cannot be accessed by a guest', function () {
    // Act & Assert
    get(route('pages.dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchased courses', function () {
    // Arrange
    $user = User::factory()
        ->has(
            Course::factory()
                ->count(2)
                ->sequence(
                    ['title' => 'Course A'],
                    ['title' => 'Course B'],
                ),
            'purchasedCourses'
        )
        ->create();

    // Act & Assert
    login($user)
        ->get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText([
            'Course A',
            'Course B',
        ]);
});

it('does not lists other courses', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    login()
        ->get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSeeText($course->title);
});

it('shows latest purchased course first', function () {
    // Arrange
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $latestPurchasedCourse = Course::factory()->create();

    $user->purchasedCourses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]);
    $user->purchasedCourses()->attach($latestPurchasedCourse, ['created_at' => Carbon::now()]);

    // Act & Assert
    login($user)
        ->get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            $latestPurchasedCourse->title,
            $firstPurchasedCourse->title,
        ]);
});

it('includes links to product videos', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory(), 'purchasedCourses')
        ->create();

    // Act & Assert
    login($user)
        ->get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch Videos')
        ->assertSee(route('pages.course-videos', Course::first()));
});

it('includes logout', function () {
    // Act & Assert
    login()
        ->get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});
