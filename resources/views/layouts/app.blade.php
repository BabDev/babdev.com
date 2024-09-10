<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:type" content="{{ $ogType ?? 'website' }}">
        <meta property="og:title" content="{{ $ogTitle ?? $title ?? config('app.name', 'BabDev') }}">
        <meta property="og:image" content="{{ asset('images/social-media.webp') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:locale" content="en_US" />
        @yield('meta')
        <title>{{ $title ?? config('app.name', 'BabDev') }}</title>
        @googlefonts
        @vite(['resources/sass/app.scss'])
        @production
            <script type="text/javascript">
                var _paq = window._paq = window._paq || [];
                _paq.push(['trackPageView']);
                _paq.push(['enableLinkTracking']);
                (function() {
                    var u="https://babdev.matomo.cloud/";
                    _paq.push(['setTrackerUrl', u+'matomo.php']);
                    _paq.push(['setSiteId', '1']);
                    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                    g.type='text/javascript'; g.async=true; g.src='//cdn.matomo.cloud/babdev.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
                })();
            </script>
        @endproduction
    </head>
    <body>
        <header class="sticky-top">
            <nav class="navbar navbar-expand-sm navbar-light bg-white">
                <div class="container">
                    <a class="navbar-brand pt-2" href="{{ route('homepage') }}">
                        {{ resource_svg('logo') }}
                        BabDev
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <nav class="collapse navbar-collapse" id="main-nav">
                        <ul class="navbar-nav ms-sm-auto">
                            <li class="nav-item dropdown">
                                <a @class(['nav-link', 'dropdown-toggle', 'active' => request()->routeIs('open-source.*')]) id="open-source-menu-item" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Open Source</a>
                                <div class="dropdown-menu" aria-labelledby="open-source-menu-item">
                                    <a @class(['dropdown-item', 'active' => request()->routeIs('open-source.packages', 'open-source.packages.package-docs-page')]) href="{{ route('open-source.packages') }}">Packages</a>
                                    <a @class(['dropdown-item', 'active' => request()->routeIs('open-source.updates', 'open-source.updates.paginated', 'open-source.update')]) href="{{ route('open-source.updates') }}">Updates</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </nav>
        </header>
        <main class="@yield('main-classes', '')">
            @yield('content')
        </main>
        <footer class="site-footer">
            <div class="site-footer__container container">
                <nav class="site-footer__navigation">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/BabDev" rel="nofollow noopener">GitHub</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://packagist.org/packages/babdev" rel="nofollow noopener">Packagist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('privacy') }}">Privacy</a>
                        </li>
                        @if(class_exists(\Laravel\Telescope\Telescope::class) && config('telescope.enabled'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('telescope') }}" target="_blank">Telescope</a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <div class="site-footer__copyright text-md-end">All rights reserved. © 2010 - {{ date('Y') }} <a href="{{ route('homepage') }}" title="BabDev">BabDev</a>.</div>
            </div>
        </footer>
        @vite(['resources/js/app.js'])
        @yield('bodyScripts')
    </body>
</html>
