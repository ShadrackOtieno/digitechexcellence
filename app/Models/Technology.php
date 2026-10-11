<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $guarded = [];

    public const GROUPS = [
        'frontend' => 'Frontend',
        'backend' => 'Backend',
        'mobile' => 'Mobile',
        'data' => 'Data',
        'cloud' => 'Cloud & DevOps',
        'design' => 'Design',
        'integrations' => 'Integrations',
        'other' => 'Other',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function groupLabel(): string
    {
        return self::GROUPS[$this->group] ?? ucfirst($this->group);
    }
}
