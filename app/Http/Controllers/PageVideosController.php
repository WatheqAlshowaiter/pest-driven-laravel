<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageVideosController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Course $course, Video $video): View
    {
        $video = $video->exists ? $video : $course->videos()->first();

        return view('pages.course-videos', compact('video'));
    }
}
