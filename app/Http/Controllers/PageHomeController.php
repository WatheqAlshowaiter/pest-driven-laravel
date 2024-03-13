<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PageHomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $courses = Course::all();

        return view('pages.home', compact('courses'));
    }
}
