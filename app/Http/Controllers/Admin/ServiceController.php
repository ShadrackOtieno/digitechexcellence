<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceController extends CrudController
{
    protected string $model = Service::class;
    protected string $route = 'services';
    protected string $title = 'Services';
    protected string $singular = 'Service';

    protected function columns(): array
    {
        return [
            ['key' => 'icon', 'label' => 'Icon', 'type' => 'icon'],
            ['key' => 'title', 'label' => 'Title'],
            ['key' => 'sort_order', 'label' => 'Order'],
            ['key' => 'is_active', 'label' => 'Active', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            'title' => ['label' => 'Title'],
            'icon' => ['label' => 'Icon', 'type' => 'select', 'options' => Service::ICONS],
            'sort_order' => ['label' => 'Display order', 'type' => 'number', 'default' => 0],
            'is_active' => ['label' => 'Show on website', 'type' => 'checkbox', 'default' => true],
            'summary' => ['label' => 'Short summary (one or two sentences)', 'type' => 'textarea', 'wide' => true, 'rows' => 3],
            'body' => ['label' => 'Description', 'type' => 'textarea', 'wide' => true, 'rows' => 6],
            'features' => ['label' => 'What is included', 'type' => 'textarea', 'wide' => true, 'rows' => 8, 'help' => 'One item per line.'],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'title' => 'required|string|max:160',
            'icon' => 'nullable|in:'.implode(',', array_keys(Service::ICONS)),
            'sort_order' => 'nullable|integer|min:0',
            'summary' => 'required|string|max:500',
            'body' => 'nullable|string|max:6000',
            'features' => 'nullable|string|max:5000',
            'is_active' => 'nullable',
        ];
    }

    protected function prepare(array $data, ?Model $item): array
    {
        if (! $item) {
            $base = Str::slug($data['title']) ?: 'service';
            $slug = $base;
            for ($i = 2; Service::where('slug', $slug)->exists(); $i++) {
                $slug = $base.'-'.$i;
            }
            $data['slug'] = $slug;
        }
        return $data;
    }
}
