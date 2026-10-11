<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /** group => [key => [label, type, help?]] */
    public const SCHEMA = [
        'Company' => [
            'company_name' => ['Company name', 'text'],
            'tagline' => ['Tagline (browser title on the home page)', 'text'],
            'founded_year' => ['Year founded', 'text', 'Shown as "since 2024" next to your project totals.'],
            'logo' => ['Logo (leave empty to use the built-in mark)', 'image'],
            'meta_description' => ['Search engine description', 'textarea'],
        ],
        'Home page' => [
            'hero_title' => ['Headline', 'textarea'],
            'hero_text' => ['Sub-headline', 'textarea'],
            'cta_title' => ['Closing call-to-action headline', 'text'],
            'cta_text' => ['Closing call-to-action text', 'textarea'],
        ],
        'About page' => [
            'about_intro' => ['Who we are (a blank line starts a new paragraph)', 'textarea'],
            'mission' => ['Mission', 'textarea'],
            'values' => ['How we work (one point per line, "Title: explanation")', 'textarea'],
        ],
        'Contact details' => [
            'email' => ['Public email', 'text'],
            'notify_email' => ['Send inquiry and message notifications to', 'text'],
            'phone' => ['Phone', 'text'],
            'whatsapp' => ['WhatsApp number', 'text', 'International format, digits only, e.g. 254712345678'],
            'address' => ['Address', 'text'],
            'hours' => ['Working hours', 'text'],
        ],
        'Brand colours' => [
            'primary_color' => ['Blue (links, accents)', 'color'],
            'ink_color' => ['Dark navy (text, footer)', 'color'],
            'accent_color' => ['Yellow (buttons, highlights)', 'color'],
        ],
        'Social media' => [
            'github' => ['GitHub URL', 'text'],
            'linkedin' => ['LinkedIn URL', 'text'],
            'twitter' => ['X / Twitter URL', 'text'],
            'instagram' => ['Instagram URL', 'text'],
        ],
    ];

    public function edit()
    {
        return view('admin.settings', ['schema' => self::SCHEMA, 'values' => Setting::map()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'primary_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'ink_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'accent_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'founded_year' => 'nullable|integer|min:1990|max:2100',
            'email' => 'nullable|email',
            'notify_email' => 'nullable|email',
            'whatsapp' => ['nullable', 'regex:/^[0-9+\s]{9,18}$/'],
        ]);

        $values = [];
        foreach (self::SCHEMA as $fields) {
            foreach ($fields as $key => $f) {
                $type = $f[1];
                if ($type === 'image') {
                    if ($request->hasFile($key)) {
                        if ($old = Setting::get($key)) {
                            Storage::disk('public')->delete($old);
                        }
                        $values[$key] = $request->file($key)->store('branding', 'public');
                    }
                    continue;
                }
                $values[$key] = $key === 'whatsapp' ? kenya_phone($request->input($key)) : $request->input($key);
            }
        }
        Setting::put($values);

        return back()->with('success', 'Settings saved.');
    }
}
