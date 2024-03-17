<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('gives back successful response for home page', function () {
    //Act & Asserts
    get(route('pages.home'))->assertOk();
});

it('gives back successful response for course details page', function () {
    //Arrange
    $course = Course::factory()->released()->create();

    //Act & Asserts
    get(route('pages.course-details', $course))->assertOk();
});

it('gives back successful response for dashboard page', function () {
    $this->withoutExceptionHandling();

    //Arrange
    $user = User::factory()->create();

    //Act & Asserts
    $this->actingAs($user);

    get('dashboard')
        ->assertOk();
});
