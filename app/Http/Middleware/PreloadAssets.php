<?php

namespace BabDev\Http\Middleware;

use BabDev\ServerPushManager\Contracts\PushManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Nova\Util;

final readonly class PreloadAssets
{
    public function __construct(private PushManager $pushManager)
    {
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        $response = $next($request);

        if (Util::isNovaRequest($request) || $this->isTelescopeRequest($request) || $response->isRedirection() || !$response instanceof Response || $request->isJson()) {
            return $response;
        }

        $this->pushManager->preload(asset('fonts/BPscript.woff2'), ['as' => 'font', 'type' => 'font/woff2']);

        return $response;
    }

    private function isTelescopeRequest(Request $request): bool
    {
        if (!config('telescope.enabled')) {
            return false;
        }

        foreach ([config('telescope.path') . '*', 'telescope-api*', 'vendor/telescope*'] as $path) {
            if ($request->is($path)) {
                return true;
            }
        }

        return false;
    }
}
