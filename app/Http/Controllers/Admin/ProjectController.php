<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $q = Project::with('category')->latest('id');
        if ($s = trim((string) $request->query('q'))) {
            $q->where(fn ($w) => $w->where('title', 'like', "%$s%")->orWhere('client_name', 'like', "%$s%"));
        }
        if ($c = $request->query('category')) {
            $q->where('category_id', $c);
        }
        if ($st = $request->query('status')) {
            $q->where('status', $st);
        }

        return view('admin.projects.index', [
            'projects' => $q->paginate(20)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.projects.form', $this->formData(new Project(['is_active' => true, 'status' => 'live', 'year' => (int) date('Y')])));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, null);
        $data['slug'] = $this->uniqueSlug($data['title']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project = Project::create($data);
        $project->technologies()->sync($request->input('technologies', []));
        $this->saveGallery($request, $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit($id)
    {
        return view('admin.projects.form', $this->formData(Project::with(['images', 'technologies'])->findOrFail($id)));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $data = $this->validated($request, $project); // the slug is kept so published links never break

        if ($request->hasFile('cover_image')) {
            $this->deleteFile($project->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project->update($data);
        $project->technologies()->sync($request->input('technologies', []));

        foreach ($project->images()->whereIn('id', (array) $request->input('remove_images', []))->get() as $img) {
            $this->deleteFile($img->path);
            $img->delete();
        }
        $this->saveGallery($request, $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy($id)
    {
        $project = Project::with('images')->findOrFail($id);
        foreach ($project->images as $img) {
            $this->deleteFile($img->path);
        }
        $this->deleteFile($project->cover_image);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    private function formData(Project $project): array
    {
        return [
            'project' => $project,
            'categories' => Category::orderBy('name')->pluck('name', 'id')->all(),
            'technologyGroups' => Technology::orderBy('name')->get()->groupBy('group'),
            'selectedTech' => $project->exists ? $project->technologies->pluck('id')->all() : [],
        ];
    }

    private function validated(Request $request, ?Project $project): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:160',
            'client_name' => 'required|string|max:160',
            'category_id' => 'nullable|integer|exists:categories,id',
            'industry' => 'nullable|string|max:120',
            'year' => 'nullable|integer|min:2000|max:2100',
            'role' => 'nullable|string|max:160',
            'duration' => 'nullable|string|max:80',
            'status' => ['required', Rule::in(array_keys(Project::STATUSES))],
            'short_description' => 'required|string|max:500',
            'challenge' => 'nullable|string|max:6000',
            'solution' => 'nullable|string|max:6000',
            'results' => 'nullable|string|max:3000',
            'live_url' => 'nullable|url|max:255',
            'repo_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'cover_image' => 'nullable|image|max:5120',
            'gallery' => 'nullable|array|max:10',
            'gallery.*' => 'image|max:5120',
            'technologies' => 'nullable|array',
            'technologies.*' => 'integer|exists:technologies,id',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        unset($data['cover_image'], $data['gallery'], $data['technologies']);

        return $data;
    }

    private function saveGallery(Request $request, Project $project): void
    {
        $order = (int) $project->images()->max('sort_order');
        foreach ($request->file('gallery', []) as $file) {
            ProjectImage::create([
                'project_id' => $project->id,
                'path' => $file->store('projects', 'public'),
                'sort_order' => ++$order,
            ]);
        }
    }

    /** Bundled demo images live in public/images and must never be deleted from disk. */
    private function deleteFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'images/')) {
            Storage::disk('public')->delete($path);
        }
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'project';
        $slug = $base;
        for ($i = 2; Project::where('slug', $slug)->exists(); $i++) {
            $slug = $base.'-'.$i;
        }
        return $slug;
    }
}
