<?php

use App\Models\Course;

use function Pest\Laravel\get;

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

it('gives back successful response for dashboard page')
    ->login()
    ->get('dashboard')
    ->assertOk();
