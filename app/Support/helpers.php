<?php

if (! function_exists('media_url')) {
    /** Public URL for an uploaded file, or for a bundled demo image (stored as "images/...") */
    function media_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        return str_starts_with($path, 'images/') ? asset($path) : asset('storage/'.$path);
    }
}

if (! function_exists('initials')) {
    function initials(?string $name): string
    {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $out = '';
        foreach (array_slice($parts, 0, 2) as $p) {
            $out .= mb_strtoupper(mb_substr($p, 0, 1));
        }
        return $out ?: 'DA';
    }
}

if (! function_exists('kenya_phone')) {
    /** 0722 123 456 -> 254722123456 */
    function kenya_phone(?string $phone): string
    {
        $d = preg_replace('/\D+/', '', (string) $phone);
        if (str_starts_with($d, '254')) {
            return $d;
        }
        if (str_starts_with($d, '0')) {
            return '254'.substr($d, 1);
        }
        if (strlen($d) === 9) {
            return '254'.$d;
        }
        return $d;
    }
}
