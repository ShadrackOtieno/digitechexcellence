<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InquiryController extends Controller
{
    public function create(Request $request)
    {
        return view('site.start', ['selectedType' => $request->query('type')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'phone' => 'nullable|string|max:40',
            'company' => 'nullable|string|max:160',
            'project_type' => 'required|in:'.implode(',', Inquiry::PROJECT_TYPES),
            'budget' => 'nullable|string|max:60',
            'timeline' => 'nullable|string|max:60',
            'message' => 'required|string|max:4000',
            'website' => 'max:0', // honeypot
        ]);
        unset($data['website']);

        $data['reference'] = 'DA-'.date('ymd').'-'.strtoupper(Str::random(4));
        $inquiry = Inquiry::create($data);

        if ($to = Setting::get('notify_email')) {
            try {
                $body = "New project inquiry {$inquiry->reference}\n\nName: {$inquiry->name}\nEmail: {$inquiry->email}\nPhone: {$inquiry->phone}\nCompany: {$inquiry->company}\n"
                    ."Type: {$inquiry->project_type}\nBudget: {$inquiry->budget}\nTimeline: {$inquiry->timeline}\n\n{$inquiry->message}\n\n".route('admin.inquiries.show', $inquiry->id);
                Mail::raw($body, fn ($m) => $m->to($to)->replyTo($inquiry->email)->subject("New project inquiry {$inquiry->reference}"));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return redirect()->route('start')->with('inquiry_ref', $inquiry->reference);
    }
}
