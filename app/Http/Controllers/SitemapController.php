<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [route('home'), route('work.index'), route('services.index'), route('about'), route('contact'), route('start')];
        foreach (Project::active()->get() as $p) {
            $urls[] = route('work.show', $p->slug);
        }
        foreach (Service::active()->get() as $s) {
            $urls[] = route('services.show', $s->slug);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $u) {
            $xml .= '  <url><loc>'.e($u).'</loc></url>'."\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
