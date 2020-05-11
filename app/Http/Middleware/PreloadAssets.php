<?php

namespace BabDev\Http\Middleware;

use BabDev\ServerPushManager\PushManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PreloadAssets
{
    private PushManager $pushManager;

    public function __construct(PushManager $pushManager)
    {
        $this->pushManager = $pushManager;
    }

    public function handle(Request $request, \Closure $next)
    {
        $response = $next($request);

        if ($this->isNovaRequest($request) || $this->isTelescopeRequest($request) || $response->isRedirection() || !$response instanceof Response || $request->isJson()) {
            return $response;
        }

        $this->pushManager->dnsPrefetch('https://fonts.googleapis.com');
        $this->pushManager->dnsPrefetch('https://fonts.gstatic.com');
        $this->pushManager->preload(asset('fonts/BPscript-webfont.woff'), ['as' => 'font', 'type' => 'font/woff']);

        return $response;
    }

    private function isNovaRequest(Request $request): bool
    {
        return config('nova.domain') === $request->getHost();
    }

    private function isTelescopeRequest(Request $request): bool
    {
        foreach ([config('telescope.path') . '*', 'telescope-api*', 'vendor/telescope*'] as $path) {
            if ($request->is($path)) {
                return true;
            }
        }

        return false;
    }
}
