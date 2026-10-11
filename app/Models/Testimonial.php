<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean', 'rating' => 'integer'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getProjectTitleAttribute(): ?string
    {
        return $this->project?->title;
    }
}
