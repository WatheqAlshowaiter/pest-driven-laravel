<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $purchasedCourses = auth()->user()->courses;

        return view('dashboard', compact('purchasedCourses'));
    }
}
