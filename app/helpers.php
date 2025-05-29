<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;

function is_filament_request(Request $request): bool
{
    $domain = config()->string('app.filament_domain', '');

    if ($domain === '') {
        return false;
    }

    if (!Str::startsWith($domain, ['http://', 'https://', '://'])) {
        $domain = $request->getScheme() . '://' . $domain;
    }

    return rtrim($request->getHttpHost(), '/') === Uri::of($domain)->host();
}

function resource_svg(string $filename): HtmlString
{
    return new HtmlString(File::get(resource_path("svg/$filename.svg")));
}
