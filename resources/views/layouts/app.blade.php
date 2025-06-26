<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">
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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @yield('assets')
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
    <body class="min-h-full flex flex-col bg-gray-50">
        <header class="sticky top-0 z-50 bg-white shadow-sm">
            <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" x-data="{ mobileMenuOpen: false }">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex shrink-0 items-center">
                        <a href="{{ route('homepage') }}" class="flex">
                            <span class="h-auto w-14">
                                {{ resource_svg('logo') }}
                            </span>
                        </a>
                    </div>

                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a @class([
                                'px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200',
                                'text-brand-orange bg-brand-orange/10' => request()->routeIs('open-source.packages', 'open-source.packages.package-docs-page'),
                                'text-gray-600 hover:text-gray-900 hover:bg-gray-100' => !request()->routeIs('open-source.packages', 'open-source.packages.package-docs-page')
                            ]) href="{{ route('open-source.packages') }}">
                                Packages
                            </a>
                            <a @class([
                                'px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200',
                                'text-brand-orange bg-brand-orange/10' => request()->routeIs('open-source.updates', 'open-source.updates.paginated', 'open-source.update'),
                                'text-gray-600 hover:text-gray-900 hover:bg-gray-100' => !request()->routeIs('open-source.updates', 'open-source.updates.paginated', 'open-source.update')
                            ]) href="{{ route('open-source.updates') }}">
                                Updates
                            </a>
                        </div>
                    </div>

                    <div class="md:hidden">
                        <button
                            type="button"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2"
                        >
                            <span class="sr-only">Open main menu</span>
                            <x-fas-bars class="h-6 w-6 fill-current" />
                        </button>
                    </div>
                </div>

                <div class="md:hidden" x-show="mobileMenuOpen" x-transition>
                    <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                        <a @class([
                            'block rounded-md px-3 py-2 text-base font-medium transition-colors duration-200',
                            'text-brand-orange bg-brand-orange/10' => request()->routeIs('open-source.packages', 'open-source.packages.package-docs-page'),
                            'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !request()->routeIs('open-source.packages', 'open-source.packages.package-docs-page')
                        ]) href="{{ route('open-source.packages') }}">
                            Packages
                        </a>
                        <a @class([
                            'block rounded-md px-3 py-2 text-base font-medium transition-colors duration-200',
                            'text-brand-orange bg-brand-orange/10' => request()->routeIs('open-source.updates', 'open-source.updates.paginated', 'open-source.update'),
                            'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => !request()->routeIs('open-source.updates', 'open-source.updates.paginated', 'open-source.update')
                        ]) href="{{ route('open-source.updates') }}">
                            Updates
                        </a>
                    </div>
                </div>
            </nav>
        </header>

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                    <nav class="flex flex-wrap items-center space-x-6">
                        <a class="text-gray-600 hover:text-brand-orange transition-colors duration-200" href="https://github.com/BabDev" rel="nofollow noopener">GitHub</a>
                        <a class="text-gray-600 hover:text-brand-orange transition-colors duration-200" href="https://packagist.org/packages/babdev" rel="nofollow noopener">Packagist</a>
                        <a class="text-gray-600 hover:text-brand-orange transition-colors duration-200" href="{{ route('privacy') }}">Privacy</a>
                        @if(class_exists(\Laravel\Telescope\Telescope::class) && config('telescope.enabled'))
                            <a class="text-gray-600 hover:text-brand-orange transition-colors duration-200" href="{{ route('telescope') }}" target="_blank">Telescope</a>
                        @endif
                    </nav>
                    <div class="text-sm text-gray-500">
                        All rights reserved. © 2010 - {{ date('Y') }} <a href="{{ route('homepage') }}" title="BabDev" class="text-brand-orange hover:text-orange-700 transition-colors duration-200">BabDev</a>.
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
