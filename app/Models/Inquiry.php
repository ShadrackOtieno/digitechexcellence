<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $guarded = [];

    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'proposal' => 'Proposal sent',
        'won' => 'Won',
        'lost' => 'Lost',
    ];

    public const PROJECT_TYPES = [
        'Website', 'Web application', 'Mobile app', 'E-commerce store',
        'UI/UX design', 'Cloud & DevOps', 'Integration (M-Pesa, WhatsApp, APIs)', 'Something else',
    ];

    public const BUDGETS = [
        'Under KSh 100,000', 'KSh 100,000 - 300,000', 'KSh 300,000 - 1,000,000', 'Above KSh 1,000,000', 'Not sure yet',
    ];

    public const TIMELINES = ['As soon as possible', 'Within 1-3 months', 'Within 3-6 months', 'Flexible'];

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
