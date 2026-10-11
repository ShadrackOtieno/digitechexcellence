<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index(Request $request)
    {
        $q = Project::active()->with(['category', 'technologies']);

        if ($slug = $request->query('category')) {
            $q->whereHas('category', fn ($c) => $c->where('slug', $slug));
        }
        if ($tech = $request->query('tech')) {
            $q->whereHas('technologies', fn ($t) => $t->where('slug', $tech));
        }
        if ($term = trim((string) $request->query('q'))) {
            $q->where(function ($w) use ($term) {
                $w->where('title', 'like', "%{$term}%")
                    ->orWhere('client_name', 'like', "%{$term}%")
                    ->orWhere('short_description', 'like', "%{$term}%");
            });
        }

        switch ($request->query('sort')) {
            case 'oldest': $q->orderBy('year')->orderBy('id'); break;
            case 'name': $q->orderBy('title'); break;
            case 'newest': $q->orderByDesc('year')->orderByDesc('id'); break;
            default: $q->ordered();
        }

        return view('site.work.index', [
            'projects' => $q->paginate(9)->withQueryString(),
            'categories' => Category::active()->withCount(['projects' => fn ($p) => $p->where('is_active', true)])->get()->filter(fn ($c) => $c->projects_count > 0)->values(),
            'technologies' => Technology::whereHas('projects', fn ($p) => $p->where('is_active', true))->orderBy('name')->get(),
            'activeCategory' => $request->query('category'),
            'activeTech' => $request->query('tech'),
            'term' => trim((string) $request->query('q')),
            'sort' => $request->query('sort', ''),
        ]);
    }

    public function show(Project $project)
    {
        abort_unless($project->is_active, 404);
        $project->load(['category', 'technologies', 'images', 'testimonials' => fn ($t) => $t->where('is_active', true)]);

        $related = Project::active()->with(['category', 'technologies'])
            ->where('id', '!=', $project->id)
            ->when($project->category_id, fn ($q) => $q->where('category_id', $project->category_id))
            ->ordered()->limit(3)->get();

        $next = Project::active()->where('id', '>', $project->id)->orderBy('id')->first()
            ?? Project::active()->where('id', '!=', $project->id)->orderBy('id')->first();

        return view('site.work.show', compact('project', 'related', 'next'));
    }
}
