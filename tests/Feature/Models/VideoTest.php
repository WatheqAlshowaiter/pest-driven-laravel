<?php

use App\Models\Video;

test('gives back readable video duration', function () {
    //Arrange
    $video = Video::factory()->make(['duration_in_min' => 10]);

    //Act & Assert
    expect($video->getReadableDuration())->toBe('10min');
});
