@php /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Package> $packages */ @endphp

@extends('layouts.app', [
    'title' => sprintf('Open Source Packages | %s', config('app.name', 'BabDev')),
])

@section('content')
    <x-hero title="Open Source Packages" />

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @forelse($packages as $package)
                <div @class([
                    'mb-8 overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200 transition-shadow duration-200 hover:shadow-md',
                    'opacity-75' => !$package->supported
                ])>
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h2 class="text-xl font-semibold text-gray-900">{{ $package->display_name }}</h2>
                                    <a class="text-gray-400 hover:text-gray-600 transition-colors duration-200" href="{{ $package->github_url }}" target="_blank" rel="nofollow noreferrer noopener" aria-label="View {{ $package->display_name }} on GitHub">
                                        <x-fab-github class="h-5 w-5 block fill-current" />
                                    </a>
                                </div>

                                <p class="mt-2 text-gray-600 leading-relaxed">
                                    {{ $package->description }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            @if(!$package->supported)
                                <span class="package-statistic package-statistic--unsupported">Package Not Supported</span>
                            @endif
                            <span class="package-statistic package-statistic--language">{{ $package->language }}</span>
                            @if($package->package_type)
                                <span class="package-statistic package-statistic--package-type package-statistic--package-type--{{ $package->package_type->value }}">{{ $package->package_type->label() }}</span>
                            @endif
                            @if($package->downloads)
                                <span class="package-statistic package-statistic--downloads">
                                    {{ number_format($package->downloads) }} <x-fas-download class="ml-1 h-3 w-3 fill-current" />
                                </span>
                            @endif
                            @if($package->stars)
                                <span class="package-statistic package-statistic--stars">
                                    {{ $package->stars }} <x-far-star class="ml-1 h-3 w-3 fill-current" />
                                </span>
                            @endif
                        </div>

                        @unless(empty($package->topics))
                            <div class="mt-4 flex flex-wrap gap-1">
                                @foreach($package->topics as $topic)
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full mr-1 mb-1">{{ $topic }}</span>
                                @endforeach
                            </div>
                        @endunless

                        @if($package->has_documentation)
                            <div class="mt-6 flex items-center justify-between">
                                <div class="flex space-x-3">
                                    <a class="inline-flex items-center rounded-md bg-brand-orange px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2 transition-colors duration-200" href="{{ route('open-source.packages.package-docs-page', ['package' => $package, 'version' => $package->latestVersion()->version, 'slug' => 'intro']) }}">
                                        View Documentation <x-far-file-lines class="ml-2 h-4 w-4 fill-current" />
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-fas-info-circle class="h-5 w-5 text-blue-400 fill-current" />
                        </div>
                        <div class="ml-3">
                            <div class="text-xl font-semibold text-blue-800">No Packages</div>
                            <p class="mt-1 text-md text-blue-700">Sorry, there are no packages available at this time.</p>
                        </div>
                    </div>
                </div>
            @endforelse

            <div class="mt-6">
                {{ Breadcrumbs::render('open-source.packages') }}
            </div>
        </div>
    </section>
@endsection
