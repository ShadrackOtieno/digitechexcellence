<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Inquiry;
use App\Models\Project;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'newInquiries' => Inquiry::where('status', 'new')->count(),
            'unread' => ContactMessage::where('is_read', false)->count(),
            'projectCount' => Project::count(),
            'liveCount' => Project::where('is_active', true)->count(),
            'demoCount' => Project::where('client_name', 'like', '%(demo)%')->count(),
            'hiddenTestimonials' => Testimonial::where('is_active', false)->count(),
            'inquiries' => Inquiry::latest()->take(6)->get(),
            'messages' => ContactMessage::latest()->take(6)->get(),
            'recentProjects' => Project::latest()->take(5)->get(),
        ]);
    }
}
