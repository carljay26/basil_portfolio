<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function about(): View
    {
        return view('public-about');
    }

    public function projects(): View
    {
        return view('public-projects');
    }

    public function skills(): View
    {
        return view('public-skills');
    }

    public function reviews(): View
    {
        return view('public-reviews');
    }

    public function contact(): View
    {
        return view('public-contact');
    }
}

