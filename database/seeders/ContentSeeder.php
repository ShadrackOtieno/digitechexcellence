<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Technology;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        Setting::put([
            'company_name' => 'DevAdvantage',
            'tagline' => 'Software that gives your business the advantage',
            'founded_year' => '',
            'meta_description' => 'DevAdvantage is a Nairobi software company building web apps, mobile apps and e-commerce systems for growing businesses.',
            'hero_title' => 'We build software that gives your business the advantage.',
            'hero_text' => 'Web apps, mobile apps and online stores, designed and built end to end. Here is some of what we have shipped.',
            'cta_title' => 'Have a product in mind?',
            'cta_text' => 'Tell us what you want to build. We reply within one working day with questions and a rough plan.',
            'about_intro' => "DevAdvantage is a software company based in Nairobi. We design and build web applications, mobile apps and online stores for businesses that want their tools to work as hard as they do.\n\nWe keep teams small and senior, talk to you directly, and ship in short cycles so you see working software early.",
            'mission' => 'To give growing businesses the same quality of software that large companies take for granted.',
            'values' => "Ship early: You see working software every couple of weeks, not at the end.\nSay it plainly: Clear estimates, clear updates, no jargon.\nBuild to last: Clean code, documentation and a handover you can rely on.\nOwn the outcome: We care whether the product works for your customers.",
            'email' => 'hello@devadvantage.test',
            'notify_email' => 'hello@devadvantage.test',
            'phone' => '+254 700 000 000',
            'whatsapp' => '254700000000',
            'address' => 'Nairobi, Kenya',
            'hours' => 'Mon to Fri, 8:00 to 17:30 EAT',
            'primary_color' => '#1E4BD8',
            'ink_color' => '#0B1F5C',
            'accent_color' => '#FFC900',
            'github' => '', 'linkedin' => '', 'twitter' => '', 'instagram' => '',
        ]);

        $cats = [];
        foreach (['Web applications', 'Mobile apps', 'E-commerce', 'Websites', 'Dashboards'] as $i => $name) {
            $cats[$name] = Category::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'sort_order' => $i, 'is_active' => true]);
        }

        $techs = [];
        $list = [
            'frontend' => ['React', 'Tailwind CSS', 'Alpine.js', 'Vue'],
            'backend' => ['Laravel', 'PHP', 'Node.js'],
            'mobile' => ['Flutter', 'React Native'],
            'data' => ['MySQL', 'PostgreSQL', 'Redis'],
            'cloud' => ['AWS', 'Docker', 'DigitalOcean'],
            'design' => ['Figma'],
            'integrations' => ['M-Pesa', 'WhatsApp API', 'Stripe'],
        ];
        $n = 0;
        foreach ($list as $group => $names) {
            foreach ($names as $name) {
                $techs[$name] = Technology::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'group' => $group, 'sort_order' => $n++]);
            }
        }

        $services = [
            ['Web applications', 'monitor', 'Custom systems that run your operations: portals, dashboards, booking and inventory tools.', "We build the internal and customer-facing systems that replace spreadsheets and manual follow-up.", "Requirements workshop and clickable prototype\nRole-based access and audit trail\nReports and exports\nDeployment and training"],
            ['Mobile apps', 'smartphone', 'Android and iOS apps from one codebase, built for real-world connectivity.', "Cross-platform apps that work well on the phones your customers actually use, including on slow networks.", "Android and iOS from one codebase\nOffline-friendly design\nPush notifications\nApp store submission"],
            ['E-commerce', 'cart', 'Online stores with M-Pesa, card payments and WhatsApp ordering.', "Stores that take payment the way your customers prefer to pay, with stock and order management behind them.", "M-Pesa and card checkout\nWhatsApp order option\nStock and order management\nDelivery zones and fees"],
            ['Websites and branding', 'palette', 'Fast, well-designed websites that explain what you do and bring in enquiries.', "Marketing sites and company profiles with an admin panel so you can update content yourself.", "Design and copy guidance\nEditable content\nSearch-friendly structure\nAnalytics setup"],
            ['Integrations and automation', 'bot', 'Connect payments, messaging and your existing tools so work moves by itself.', "We connect your systems to M-Pesa, WhatsApp, email and accounting tools and automate repetitive steps.", "M-Pesa and WhatsApp integrations\nAPI design and webhooks\nScheduled jobs and reports\nData migration"],
            ['Hosting and support', 'cloud', 'Reliable hosting, backups and ongoing maintenance after launch.', "We stay on after launch so your product keeps working and keeps improving.", "Managed hosting and backups\nMonitoring and security updates\nMonthly improvement hours\nPriority support"],
        ];
        foreach ($services as $i => [$title, $icon, $summary, $body, $features]) {
            Service::updateOrCreate(['slug' => Str::slug($title)], compact('title', 'icon', 'summary', 'body', 'features') + ['sort_order' => $i, 'is_active' => true]);
        }

        // Placeholder projects. They are flagged "(demo)" so they are easy to find and replace with real work.
        $demos = [
            ['Mkulima Market', 'Mkulima Co-op (demo)', 'Web applications', 'Agriculture', 'delivered', 'A marketplace connecting smallholder farmers with buyers, with price listings and order tracking.', ['Laravel', 'MySQL', 'Tailwind CSS', 'M-Pesa'], 'mkulima'],
            ['PesaTrack', 'PesaTrack Ltd (demo)', 'Mobile apps', 'Fintech', 'live', 'A personal finance app that reads M-Pesa messages and shows where the money goes each month.', ['Flutter', 'Node.js', 'PostgreSQL'], 'pesatrack'],
            ['FleetLine', 'FleetLine Logistics (demo)', 'Dashboards', 'Logistics', 'live', 'A dispatch and tracking dashboard for a delivery fleet, with driver status and proof of delivery.', ['Laravel', 'Vue', 'MySQL', 'Redis'], 'fleetline'],
            ['Duka Kit', 'Duka Kit Stores (demo)', 'E-commerce', 'Retail', 'live', 'An online store with M-Pesa checkout and one-tap WhatsApp ordering for hardware and home goods.', ['Laravel', 'Alpine.js', 'Tailwind CSS', 'M-Pesa', 'WhatsApp API'], 'dukakit'],
            ['ClinicFlow', 'ClinicFlow Health (demo)', 'Web applications', 'Healthcare', 'in_development', 'Appointment booking and patient reminders for a group of private clinics.', ['Laravel', 'React', 'MySQL', 'WhatsApp API'], 'clinicflow'],
            ['Savanna Stays', 'Savanna Stays (demo)', 'Websites', 'Hospitality', 'delivered', 'A lodge website with room galleries, enquiry forms and seasonal rates the owner edits herself.', ['Laravel', 'Tailwind CSS', 'MySQL'], 'savanna'],
        ];
        foreach ($demos as $i => [$title, $client, $cat, $industry, $status, $short, $stack, $img]) {
            $p = Project::updateOrCreate(['slug' => Str::slug($title)], [
                'category_id' => $cats[$cat]->id,
                'title' => $title,
                'client_name' => $client,
                'industry' => $industry,
                'year' => 2026,
                'role' => 'Design and development',
                'duration' => '10 weeks',
                'status' => $status,
                'short_description' => $short,
                'challenge' => 'Placeholder text. Replace this with the problem the client came to you with, in their words if possible.',
                'solution' => 'Placeholder text. Describe what you built and the decisions that mattered.',
                'results' => "Placeholder: replace with a real, measurable result\nPlaceholder: add a second result\nPlaceholder: add a third result",
                'cover_image' => "images/demo/{$img}.svg",
                'is_featured' => $i < 4,
                'is_active' => true,
                'sort_order' => $i,
            ]);
            $p->technologies()->sync(collect($stack)->map(fn ($t) => $techs[$t]->id)->all());
        }

        // Inactive samples so the site never shows invented people or quotes.
        TeamMember::updateOrCreate(['name' => 'Your Name'], ['title' => 'Founder and lead developer', 'bio' => 'Replace with your real bio, then tick "Show on website".', 'sort_order' => 0, 'is_active' => false]);
        Testimonial::updateOrCreate(['author_name' => 'Client Name'], ['author_role' => 'Role', 'company' => 'Company', 'quote' => 'Replace with a real quote from a client who has agreed to be quoted.', 'rating' => 5, 'sort_order' => 0, 'is_active' => false]);
    }
}
