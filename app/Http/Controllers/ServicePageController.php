<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;

class ServicePageController extends Controller
{
    public function index()
    {
        return view('site.services.index', ['services' => Service::active()->get()]);
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);

        return view('site.services.show', [
            'service' => $service,
            'others' => Service::active()->where('id', '!=', $service->id)->get(),
            'projects' => Project::active()->with(['category', 'technologies'])->where('is_featured', true)->ordered()->limit(3)->get(),
        ]);
    }
}
