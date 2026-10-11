<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];

    /** Icon keys available in resources/views/components/icon.blade.php */
    public const ICONS = [
        'monitor' => 'Monitor (web apps)',
        'smartphone' => 'Phone (mobile apps)',
        'cart' => 'Cart (e-commerce)',
        'palette' => 'Palette (design)',
        'cloud' => 'Cloud',
        'code' => 'Code',
        'database' => 'Database',
        'server' => 'Server',
        'bot' => 'Bot (automation)',
        'rocket' => 'Rocket',
        'shield-check' => 'Shield (security)',
        'layers' => 'Layers',
        'cpu' => 'Chip',
        'globe' => 'Globe',
        'lightbulb' => 'Lightbulb (strategy)',
        'bar-chart' => 'Chart (analytics)',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /** @return array<int, string> */
    public function featureList(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $this->features))));
    }
}
