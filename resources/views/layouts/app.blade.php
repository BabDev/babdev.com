<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <link href="{{ PushManager::preload(mix('css/app.css'), ['as' => 'stylesheet']) }}" rel="stylesheet">
    </head>
    <body>
        <header class="sticky-top">
            <nav class="navbar navbar-expand-sm navbar-light bg-white">
                <div class="container">
                    <a class="navbar-brand pt-2" href="{{ route('homepage') }}">
                        <img src="{{ PushManager::preload(asset('images/logos/babdev.svg'), ['as' => 'image']) }}" class="d-inline-block" alt="">
                        BabDev
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <nav class="collapse navbar-collapse" id="main-nav">
                        <ul class="navbar-nav ml-sm-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Blog</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Open Source</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('open-source.packages') }}">Packages</a>
                                    <a class="dropdown-item" href="{{ route('open-source.updates') }}">Updates</a>
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
                <div class="site-footer__copyright text-md-right">All rights reserved. © 2010 - {{ date('Y') }} <a href="{{ route('homepage') }}" title="BabDev">BabDev</a>.</div>
            </div>
        </footer>
        <script src="{{ PushManager::preload(mix('js/manifest.js'), ['as' => 'script']) }}"></script>
        <script src="{{ PushManager::preload(mix('js/vendor.js'), ['as' => 'script']) }}"></script>
        <script src="{{ PushManager::preload(mix('js/app.js'), ['as' => 'script']) }}"></script>
        @yield('bodyScripts')
    </body>
</html>
