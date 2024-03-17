<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('cannot be accessed by a guest', function () {
    // Act & Assert
    get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchased courses', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory()->count(2)
            ->state(new Sequence(
                ['title' => 'Course A'],
                ['title' => 'Course B'],
            )))
        ->create();
    // Act & Assert
    $this->actingAs($user);
    get(route('dashboard'))
        ->assertOk()
        ->assertSeeText([
            'Course A',
            'Course B',
        ]);
});

it('does not lists other courses', function () {
    // Arrange
    // Act
    // Assert
});

it('shows latest purchased course first', function () {
    // Arrange
    // Act
    // Assert
});

it('includes links to product videos', function () {
    // Arrange
    // Act
    // Assert
});
