<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;

class TestimonialController extends CrudController
{
    protected string $model = Testimonial::class;
    protected string $route = 'testimonials';
    protected string $title = 'Testimonials';
    protected string $singular = 'Testimonial';

    protected function query()
    {
        return Testimonial::with('project')->orderBy('sort_order')->orderBy('id');
    }

    protected function columns(): array
    {
        return [
            ['key' => 'author_name', 'label' => 'Author'],
            ['key' => 'company', 'label' => 'Company'],
            ['key' => 'project_title', 'label' => 'Project'],
            ['key' => 'is_active', 'label' => 'Shown', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            'author_name' => ['label' => 'Client name'],
            'author_role' => ['label' => 'Client role (e.g. Founder)'],
            'company' => ['label' => 'Company'],
            'project_id' => ['label' => 'Related project (optional)', 'type' => 'select', 'options' => ['' => 'None'] + Project::orderBy('title')->pluck('title', 'id')->all()],
            'quote' => ['label' => 'What they said (use their real words)', 'type' => 'textarea', 'wide' => true, 'rows' => 5],
            'rating' => ['label' => 'Rating', 'type' => 'select', 'options' => [5 => '5 stars', 4 => '4 stars', 3 => '3 stars']],
            'sort_order' => ['label' => 'Display order', 'type' => 'number', 'default' => 0],
            'is_active' => ['label' => 'Show on website', 'type' => 'checkbox', 'default' => false, 'help' => 'Only publish testimonials your clients have agreed to.'],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'author_name' => 'required|string|max:120',
            'author_role' => 'nullable|string|max:120',
            'company' => 'nullable|string|max:160',
            'project_id' => 'nullable|integer|exists:projects,id',
            'quote' => 'required|string|max:1500',
            'rating' => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ];
    }
}
