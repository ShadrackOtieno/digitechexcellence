<?php

namespace App\Http\Controllers\Admin;

use App\Models\Technology;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TechnologyController extends CrudController
{
    protected string $model = Technology::class;
    protected string $route = 'technologies';
    protected string $title = 'Technologies';
    protected string $singular = 'Technology';

    protected function query()
    {
        return Technology::query()->orderBy('group')->orderBy('name');
    }

    protected function columns(): array
    {
        return [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'group', 'label' => 'Group'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Name', 'help' => 'e.g. Laravel, Flutter, PostgreSQL.'],
            'group' => ['label' => 'Group', 'type' => 'select', 'options' => Technology::GROUPS],
        ];
    }

    protected function rules(?Model $item): array
    {
        return ['name' => 'required|string|max:80', 'group' => 'required|in:'.implode(',', array_keys(Technology::GROUPS))];
    }

    protected function prepare(array $data, ?Model $item): array
    {
        if (! $item) {
            $base = Str::slug($data['name']) ?: 'tech';
            $slug = $base;
            for ($i = 2; Technology::where('slug', $slug)->exists(); $i++) {
                $slug = $base.'-'.$i;
            }
            $data['slug'] = $slug;
        }
        return $data;
    }
}
