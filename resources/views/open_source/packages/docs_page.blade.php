@php /** @var \App\Models\Package $package */ @endphp
@php /** @var \App\Models\PackageVersion $package_version */ @endphp
@php /** @var string $contents */ @endphp
@php /** @var string $sidebar */ @endphp
@php /** @var string|null $title */ @endphp
@php /** @var string $version */ @endphp
@php /** @var string $slug */ @endphp

@extends('layouts.app', [
    'title' => sprintf('%s%s %s Documentation | %s', ($title !== null ? ($title . ' | ') : ''), $package->display_name, $version, config('app.name', 'BabDev')),
])

@section('assets')
    @vite(['resources/js/docs.js'])
@endsection

@section('content')
    <x-hero :title="$package->display_name" subtitle="Documentation" />

    <article class="py-8">
        <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <aside class="lg:col-span-3 xl:col-span-2 mb-6 lg:mb-0">
                    <div class="sticky top-24 space-y-6">
                        @if($package->versions->count() > 1)
                            <div class="relative" x-data="{ open: false }">
                                <button
                                    @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-orange"
                                >
                                    <span>Version {{ $version }}</span>
                                    {{-- x-fas-chevron-down --}}
                                    <svg class="h-4 w-4 transform transition-transform duration-200 fill-current" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. -->
                                        <path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/>
                                    </svg>
                                </button>

                                <div
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    @click.away="open = false"
                                    class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="py-1 max-h-60 overflow-auto">
                                        @foreach($package->versions as $availablePackageVersion)
                                            <a @class([
                                                'block px-4 py-2 text-sm transition-colors duration-200',
                                                'bg-brand-orange text-white' => $availablePackageVersion->version === $version,
                                                'text-gray-700 hover:bg-gray-100' => $availablePackageVersion->version !== $version
                                            ]) href="{{ route('open-source.packages.package-docs-page', ['package' => $package, 'version' => $availablePackageVersion->version, 'slug' => $slug]) }}">
                                                {{ $availablePackageVersion->version }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <nav class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="p-4">
                                <x-markdown class="docs-sidebar-nav" :active-slug="$slug">{!! $sidebar !!}</x-markdown>
                            </div>
                        </nav>
                    </div>
                </aside>

                <main class="lg:col-span-9 xl:col-span-10">
                    @if($package_version->released === null)
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <x-fas-info-circle class="h-5 w-5 text-blue-400 fill-current" />
                                </div>
                                <div class="ml-3">
                                    <div class="text-xl font-semibold text-blue-800">Version Not Yet Released</div>
                                    <p class="mt-1 text-md text-blue-700">You are viewing the documentation for the {{ $package_version->version }} branch of the {{ $package->display_name }} package which has not yet been released. Be aware that the API for this version may change before release.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($package_version->support_ended)
                        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <x-fas-exclamation-triangle class="h-5 w-5 text-yellow-400 fill-current" />
                                </div>
                                <div class="ml-3">
                                    <div class="text-xl font-semibold text-yellow-800">Version No Longer Supported</div>
                                    <p class="mt-1 text-md text-yellow-700">You are viewing the documentation for the {{ $package_version->version }} branch of the {{ $package->display_name }} package which is no longer supported as of {{ $package_version->end_of_support->format('F j, Y') }}. You are advised to upgrade as soon as possible to a supported version.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-8">
                            <x-markdown class="docs-content prose max-w-none" anchors>{!! $contents !!}</x-markdown>
                        </div>
                    </div>

                    <div class="mt-6">
                        {{ Breadcrumbs::render('open-source.packages.package-docs-page', $package, $package_version, $title) }}
                    </div>
                </main>
            </div>
        </div>
    </article>
@endsection
