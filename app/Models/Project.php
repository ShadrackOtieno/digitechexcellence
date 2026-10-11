<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];
    protected $casts = ['is_featured' => 'boolean', 'is_active' => 'boolean', 'year' => 'integer'];

    public const STATUSES = [
        'live' => 'Live',
        'delivered' => 'Delivered',
        'in_development' => 'In development',
        'concept' => 'Concept',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class)->orderBy('technologies.name');
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderByDesc('year')->orderByDesc('id');
    }

    public function getCoverUrlAttribute(): ?string
    {
        return media_url($this->cover_image);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    /** Domain shown in the browser-frame address bar. */
    public function getHostAttribute(): string
    {
        $host = $this->live_url ? parse_url($this->live_url, PHP_URL_HOST) : null;
        return $host ?: 'devadvantage.work/'.$this->slug;
    }

    /** @return array<int, string> */
    public function resultList(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $this->results))));
    }

    public function isDemo(): bool
    {
        return str_contains((string) $this->client_name, '(demo)');
    }
}
