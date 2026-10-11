<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Technology;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $with = ['category', 'technologies'];

        $featured = Project::active()->where('is_featured', true)->with($with)->ordered()->limit(5)->get();
        if ($featured->count() < 3) {
            $featured = Project::active()->with($with)->ordered()->limit(5)->get();
        }

        $liveProjects = Project::active();
        $founded = (int) Setting::get('founded_year', 0);

        return view('site.home', [
            'featured' => $featured,
            'heroProjects' => $featured->take(3),
            'services' => Service::active()->get(),
            'technologies' => Technology::whereHas('projects', fn ($q) => $q->where('is_active', true))->orderBy('name')->get(),
            'testimonials' => Testimonial::active()->with('project')->limit(3)->get(),
            'stats' => [
                'projects' => (clone $liveProjects)->count(),
                'clients' => (clone $liveProjects)->distinct()->count('client_name'),
                'technologies' => Technology::whereHas('projects', fn ($q) => $q->where('is_active', true))->count(),
                'since' => $founded > 1990 ? $founded : null,
            ],
        ]);
    }
}
