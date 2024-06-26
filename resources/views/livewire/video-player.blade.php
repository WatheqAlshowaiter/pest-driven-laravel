<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" class="w-full aspect-video rounded mb-4 md:mb-8"
        webkitallowfullscreen mozallowfullscreen allowfullscreen>
    </iframe>

    <h3>{{ $video?->title }} ({{ $video->getReadableDuration() }}min)</h3>
    <h3>{{ $video?->description }}</h3>

        @if ($video->alreadyWatchedByCurrentUser())
            <button wire:click="markVideoAsNotCompleted">Mark as not completed</button>
        @else
            <button wire:click="markVideoAsCompleted">Mark as completed</button>
        @endif

    <ul>
        @foreach ($courseVideos as $courseVideo)
            <li>
                @if ($this->isCurrentVideo($courseVideo))
                    {{ $courseVideo->title }}
                @else
                    <a href="{{ route('pages.course-videos', $courseVideo) }}">
                        {{ $courseVideo->title }}
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
