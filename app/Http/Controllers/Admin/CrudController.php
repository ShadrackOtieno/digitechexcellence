<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class CrudController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;
    protected string $route;
    protected string $title;
    protected string $singular;

    abstract protected function columns(): array;

    abstract protected function fields(): array;

    abstract protected function rules(?Model $item): array;

    protected function query()
    {
        return ($this->model)::query()->orderBy('sort_order')->orderBy('id');
    }

    protected function prepare(array $data, ?Model $item): array
    {
        return $data;
    }

    public function index()
    {
        return view('admin.crud.index', [
            'items' => $this->query()->paginate(20),
            'columns' => $this->columns(),
            'route' => $this->route,
            'title' => $this->title,
            'singular' => $this->singular,
        ]);
    }

    public function create()
    {
        return view('admin.crud.form', [
            'item' => new $this->model,
            'fields' => $this->fields(),
            'route' => $this->route,
            'title' => $this->title,
            'singular' => $this->singular,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->collect($request, null);
        ($this->model)::create($data);

        return redirect()->route('admin.'.$this->route.'.index')->with('success', $this->singular.' added.');
    }

    public function edit(int|string $id)
    {
        return view('admin.crud.form', [
            'item' => ($this->model)::findOrFail($id),
            'fields' => $this->fields(),
            'route' => $this->route,
            'title' => $this->title,
            'singular' => $this->singular,
        ]);
    }

    public function update(Request $request, int|string $id)
    {
        $item = ($this->model)::findOrFail($id);
        $item->update($this->collect($request, $item));

        return redirect()->route('admin.'.$this->route.'.index')->with('success', $this->singular.' saved.');
    }

    public function destroy(int|string $id)
    {
        $item = ($this->model)::findOrFail($id);

        foreach ($this->fields() as $key => $field) {
            if (($field['type'] ?? 'text') === 'image' && $item->{$key}) {
                $this->deleteFile($item->{$key});
            }
        }

        $item->delete();

        return redirect()->route('admin.'.$this->route.'.index')->with('success', $this->singular.' deleted.');
    }

    protected function collect(Request $request, ?Model $item): array
    {
        $data = $request->validate($this->rules($item));
        $fields = $this->fields();

        foreach ($fields as $key => $field) {
            $type = $field['type'] ?? 'text';

            if ($type === 'checkbox') {
                $data[$key] = $request->boolean($key);
            } elseif ($type === 'image') {
                unset($data[$key]);
                if ($request->hasFile($key)) {
                    if ($item && $item->{$key}) {
                        $this->deleteFile($item->{$key});
                    }
                    $data[$key] = $request->file($key)->store($this->route, 'public');
                }
            }
        }

        return $this->prepare($data, $item);
    }

    protected function deleteFile(string $path): void
    {
        // Seeded demo images live in public/images and must never be removed.
        if (! str_starts_with($path, 'images/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
