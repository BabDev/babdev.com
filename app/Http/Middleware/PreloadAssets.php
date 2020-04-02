<?php

namespace BabDev\Http\Middleware;

use BabDev\ServerPushManager\PushManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Nova\Nova;

class PreloadAssets
{
    private PushManager $pushManager;

    public function __construct(PushManager $pushManager)
    {
        $this->pushManager = $pushManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $response = $next($request);

        if ($this->isNovaRequest($request) || $response->isRedirection() || !$response instanceof Response || $request->isJson()) {
            return $response;
        }

        $this->pushManager->dnsPrefetch('https://fonts.googleapis.com');
        $this->pushManager->dnsPrefetch('https://fonts.gstatic.com');
        $this->pushManager->preload(asset('fonts/BPscript-webfont.woff'), ['as' => 'font', 'type' => 'font/woff']);

        return $response;
    }

    private function isNovaRequest(Request $request): bool
    {
        $path = trim(Nova::path(), '/') ?: '/';

        return $request->is($path) ||
            $request->is(trim($path . '/*', '/')) ||
            $request->is('nova-api/*') ||
            $request->is('nova-vendor/*');
    }
}
