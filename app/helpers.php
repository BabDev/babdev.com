<?php

use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

function is_filament_request(Request $request): bool
{
    $domain = config('app.filament_domain');

    if ($domain === null) {
        return false;
    }

    if (!Str::startsWith($domain, ['http://', 'https://', '://'])) {
        $domain = $request->getScheme() . '://' . $domain;
    }

    $uri = parse_url((string) $domain);

    return rtrim($request->getHttpHost(), '/') === $uri['host'];
}

function resource_svg(string $filename): HtmlString
{
    return new HtmlString(file_get_contents(resource_path("svg/$filename.svg")));
}
