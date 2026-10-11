<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryController extends CrudController
{
    protected string $model = Category::class;
    protected string $route = 'categories';
    protected string $title = 'Categories';
    protected string $singular = 'Category';

    protected function columns(): array
    {
        return [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'slug', 'label' => 'URL slug'],
            ['key' => 'sort_order', 'label' => 'Order'],
            ['key' => 'is_active', 'label' => 'Active', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Name', 'help' => 'Shown as a filter on the Work page, e.g. Web applications.'],
            'sort_order' => ['label' => 'Display order', 'type' => 'number', 'default' => 0],
            'is_active' => ['label' => 'Show on website', 'type' => 'checkbox', 'default' => true],
        ];
    }

    protected function rules(?Model $item): array
    {
        return ['name' => 'required|string|max:120', 'sort_order' => 'nullable|integer|min:0', 'is_active' => 'nullable'];
    }

    protected function prepare(array $data, ?Model $item): array
    {
        if (! $item) {
            $base = Str::slug($data['name']) ?: 'category';
            $slug = $base;
            for ($i = 2; Category::where('slug', $slug)->exists(); $i++) {
                $slug = $base.'-'.$i;
            }
            $data['slug'] = $slug;
        }
        return $data;
    }
}
