<?php

namespace App\Livewire;

use App\Models\Video;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VideoPlayer extends Component
{
    public $video;

    // public $courseVideos;

    public function mount()
    {
        // $this->courseVideos = $this->video->course->videos;
    }

    public function render(): View
    {
        return view('livewire.video-player', ['courseVideos' => $this->video->course->videos]);
    }

    public function markVideoAsCompleted(): void
    {
        Auth::user()->watchedVideos()->attach($this->video);
    }

    public function markVideoAsNotCompleted(): void
    {
        Auth::user()->watchedVideos()->detach($this->video);
    }

    public function isCurrentVideo(Video $videoToCheck): bool
    {
        return $this->video->is($videoToCheck);
    }
}
