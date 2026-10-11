<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\Technology;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function about()
    {
        return view('site.about', [
            'team' => TeamMember::active()->get(),
            'technologies' => Technology::orderBy('group')->orderBy('name')->get()->groupBy('group'),
            'testimonials' => Testimonial::active()->with('project')->limit(2)->get(),
        ]);
    }

    public function contact()
    {
        return view('site.contact');
    }
}
